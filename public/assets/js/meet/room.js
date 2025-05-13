import { initializeMediaDevices } from './main.js';

let stream = null;
let popover;
let popoverOpenable = false;
let peer_ids = [];
let micStream, cameraStream;
const btn = $('#screen-capture');
const popoverBtn = document.getElementById('screen-capture');
const url = "stun:stun.l.google.com:19302";
const prefix = {
    member_card_prefix: 'member-',
    member_video_card_prefix: 'video-'
}
const peerConfig = {
    config: {
        iceServers: [
            { url }
        ]
    }
};

const peer = new Peer(peerConfig);

const callPeers = (peer_id = null) => {
    const instance = window.roomMembersInstance;

    const ids = peer_id == null ? peer_ids : [{
        peer_id
    }];

    ids.forEach(user => {
        if (micStream && !isStreamActive(micStream)) {
            const call = peer.call(user.peer_id, micStream);
            if (user?.call?.mic) {
                user.call.mic = call;
            }
        }

        if (cameraStream && cameraStream.getTracks().every(t => t.enabled && t.readyState == "live")) {
            const call = peer.call(user.peer_id, cameraStream, {
                metadata: {
                    username: instance.currentUserName,
                    user_id: instance.currentUserId
                }
            });
            if (user?.call?.cmera) {
                user.call.camera = call;
            }
        }
    })
}

export function broadcastMedia(streams) {
    [micStream, cameraStream] = streams;

    callPeers();
}

function createObjSrcVideo(stream) {
    const video = document.createElement('video');
    video.srcObject = stream;
    video.autoplay = true;
    video.muted = true; // helpful for autoplay
    video.playsInline = true;

    video.play().catch(err => {
        console.error('Playback failed:', err);
    });

    return video;
}

function createUserVideoCard(stream, card_id, user_name) {
    const card = document.createElement('div');
    card.classList.add(
        ...`flex flex-col items-center
        rounded-xl
        transition-all duration-300 hover:-translate-y-1
        hover:border-purple-500/30 w-1/3 flex-shrink-0 flex-grow relative overflow-hidden bg-black`
            .trim().split(/\s+/)
    );

    const userCard = document.getElementById(card_id);

    // Create and configure video element
    const video = createObjSrcVideo(stream);
    video.classList.add(
        ...'rounded-md w-full aspect-video object-cover'.split(' ')
    );
    video.playsInline = true;
    video.autoplay = true;
    video.muted = true;

    // Create the user's name label
    const span = document.createElement('span');
    span.classList.add(
        ...'absolute bottom-0 left-0 p-2 text-white rounded-md font-bold bg-gray-700 bg-opacity-50 z-10'.split(' ')
    );
    span.innerText = user_name;

    // Final DOM setup
    userCard.classList.toggle('hidden');
    card.appendChild(span);
    card.appendChild(video);

    return card;
}

function initializeRoom() {
    peer.on('open', peer_id => {
        // this will help to broadcast our peer id to others so they can call us.
        Livewire.dispatch('add-user-to-room', { peer_id });
    })

    peer.on('call', call => {
        const { metadata } = call;

        call.answer();

        call.on('stream', remoteStream => {
            identifyStreamType(remoteStream, metadata);
        })

        call.on('close', () => {
            // check if the caller video card is available
            const videoElement = document.getElementById(prefix.member_video_card_prefix + metadata.user_id);
            
            if(videoElement){
                videoElement.remove();
            }
        });
    })

    const handleRemoteCameraStream = (stream, metadata = null) => {
        const cardContainer = document.getElementById('members-list');
        const card_id = prefix.member_card_prefix + metadata.user_id;
        const user_name = metadata.username;

        const card = createUserVideoCard(stream, card_id, user_name);
        card.id = prefix.member_video_card_prefix + metadata.user_id

        cardContainer.appendChild(card);

        stream.onended = (e) => {
            cardContainer.removeChild(card);
        }
    }

    const handleRemoteAudioStream = (stream, metadata = null) => {
        const audio = document.createElement('audio');
        audio.srcObject = stream;
        audio.muted = true;
        audio.autoplay = true;
        audio.playsInline = true;
        document.body.appendChild(audio);

        audio.muted = false;
        audio.play();
    }

    const identifyStreamType = (stream, metadata = null) => {
        const callbacks = {
            video: handleRemoteCameraStream,
            audio: handleRemoteAudioStream
        }

        for (const track of stream.getTracks()) {
            if (track && callbacks[track.kind]) {
                return callbacks[track.kind](stream, metadata);
            }
        }
    }

    document.addEventListener('event:peer-joined', ({ detail: { user } }) => {
        const user_peer = {
            id: user.user_id,
            peer_id: user.peer_id,
            call: {
                mic: null,
                camera: null
            }
        }

        // store in the frontend - temporary to access real time users
        peer_ids.push(user_peer);

        // call the peer when joins
        callPeers(user.peer_id);
    });

    document.addEventListener('cameraStopped', () => {
    })

    // Listen for the frontend event when the alpine will be fully initiazlied

    if (Alpine == undefined || Livewire == undefined || Echo == undefined)
        return;

    document.addEventListener('existing-members', async (event) => {
        [micStream, cameraStream] = await initializeMediaDevices(false)

        waitForAlpineInit(() => {

            const data = event.detail[0];
            const instance = window.roomMembersInstance;
            const users = instance.users;
            const room_id = instance.room;

            document.addEventListener('event:peer-left', ({ detail: { user } }) => {
                peer_ids = peer_ids.filter(u => {
                    return u.id !== user.id
                });

            });

            window.addEventListener('beforeunload', () => {
                if (peer && !peer.destroyed) {
                    peer.destroy(); // This will close all connections and notify others
                }
            });

            data.members.forEach(member => {
                const user_peer = {
                    id: member.user_id,
                    peer_id: member.peer_id
                }

                peer_ids.push(user_peer);
            });

            if (cameraStream) {
                const cardContainer = document.getElementById('members-list');
                const card_id = prefix.member_card_prefix + instance.currentUserId;
                const user_name = instance.currentUserName;

                const card = createUserVideoCard(cameraStream, card_id, user_name);
                card.id = prefix.member_video_card_prefix + instance.currentUserId

                cardContainer.appendChild(card);

                cameraStream.onended = (e) => {
                    cardContainer.removeChild(card);
                }
            }

            if (micStream || cameraStream) {
                callPeers();
            }
        });
    });
}

function waitForAlpineInit(callback, interval = 100) {
    const check = () => {
        if (window.roomMembersInstance?.users.length > 0) {
            callback();
        } else {
            setTimeout(check, interval);
        }
    }

    check();
}

// Initialize the button onclick event.
if (popoverBtn) popoverBtn.onclick = screenCapture;

function showDate() {
    const date = new Date();
    const textContent = `${date.toString().split(' ')[0]},  ${date.getHours()}:${String(date.getMinutes()).padStart(2, '0')}`;
    $('#date-time').text(textContent);
}

function updateDateTime() {
    showDate();

    const date = new Date();
    const remainingSeconds = 60 - date.getSeconds();

    setTimeout(updateDateTime, remainingSeconds * 1000);
}

updateDateTime();

async function screenCapture() {
    if (popover) {
        popover.hide();
        popover = null;
    }

    // Make the Button disabled
    $(btn).attr('disabled', true);

    await getDisplay()
        .then((captureStream) => {
            stream = captureStream;

            // Make the button to toggle the screens
            togglePopOverAttr();

            // Remove the button's focus (this should work)
            $(btn).blur();

            popoverOpenable = true;
            popoverBtn.onclick = handleClick;

            togglePrimary();

            // Handle stream end
            stream.getVideoTracks()[0].onended = handleScreenEnd;
        })
        .catch((err) => console.log('Permission Denied'))

        // Enable the button
        .finally(() => $(btn).attr('disabled', false));
}

function togglePrimary() {
    $(btn)
        .removeClass('bg-gray-700 hover:bg-gray-800')
        .addClass('bg-blue')
        .blur();
}

function toggleSecondary() {
    $(btn)
        .addClass('bg-gray-700 hover:bg-gray-800') // Reset the button styles after screen capture ends
        .removeClass('bg-blue');
}

function handleClick(e) {
    if (!popoverOpenable || !stream || !stream.active) {
        if (!popoverBtn.onclick) popoverBtn.onclick = screenCapture
    }

    else if (popoverOpenable && stream.active) {
        if ($('#popover-click')) showPopOverElement();

        e.stopPropagation();

        const popoverElement = document.getElementById('popover-click');

        popover = new Popover(popoverElement, popoverBtn, {
            triggerType: 'click',
            placement: 'bottom',
        });

        console.log(popover);

        // Show popover
        popover.show();
    } else popoverOpenable = false;
}

function togglePopOverAttr() {
    $(btn).attr('data-popover-target', (_, attr) => {
        if (attr) {
            $(btn).removeAttr('data-popover-target');  // Remove the attribute if it's set
            return null;
        } else {
            return 'popover-click';  // Set the attribute if it's not set
        }
    });

    $(btn).attr('data-popover-trigger', (_, attr) => {
        if (attr) {
            $(btn).removeAttr('data-popover-trigger');  // Remove the attribute if it's set
            return null;
        } else {
            return 'click';  // Set the attribute if it's not set
        }
    });
};

function getAudioTracks() { };

function getDisplay() {
    return new Promise(async (resolve, reject) => {
        try {
            // get screen
            const stream = await navigator.mediaDevices.getDisplayMedia({ audio: true });

            // Resolve stream 
            resolve(stream);

        } catch (error) {
            reject(false);
        }
    })
}

function stopPresentation() {
    if (stream && stream.active) {
        stream.getTracks().forEach(track => track.stop())

        // change the popoverOpenable
        popoverOpenable = false;

        removePopOverElement();
        // removePopOverElement();
        popoverBtn.onclick = screenCapture;

        toggleSecondary();
    }
}

function removePopOverElement() {
    $('#popover-click').fadeOut(200);
}

function showPopOverElement() {
    $('#popover-click').fadeIn();
}

function handleScreenEnd() {
    stopPresentation();
}

function makePopoverElement() {
    // Create the popover div
    const popover = $('<div>', {
        id: 'popover-click',
        'data-popover': 'true',
        class: 'absolute overflow-hidden z-10 invisible w-72 transition-opacity duration-300 p-0 rounded-md shadow-lg opacity-0 bg-[#1e1f20]'
    });

    // Create the first anchor element inside the popover
    const firstLink = $('<a>', {
        href: '#',
        class: 'block text-gray-300 py-[.825rem] px-4 hover:bg-gray-700 hover:text-white hover:rounded-none transition-all duration-200 w-full'
    }).append(
        $('<span>', { class: 'font-medium flex gap-3' }).append(
            $('<span>', { class: 'material-symbols-outlined' }).text('select_window'),
            $('<span>').text('Present Something Else')
        )
    );

    // Create the second anchor element inside the popover
    const secondLink = $('<a>', {
        href: 'javascript:void(0)',
        onclick: 'stopPresentation()', // Assuming stopPresentation is defined elsewhere
        class: 'block text-gray-300 py-[.825rem] px-4 hover:bg-gray-700 hover:text-white hover:rounded-none transition-all duration-200 w-full'
    }).append(
        $('<span>', { class: 'font-medium flex gap-3' }).append(
            $('<span>', { class: 'material-symbols-outlined' }).text('cancel_presentation'),
            $('<span>').text('Stop Presenting')
        )
    );

    // Create the popper arrow div
    const arrow = $('<div>', {
        'data-popper-arrow': true,
        class: 'bg-[#1e1f20]'
    });

    // Append all elements to the popover div
    popover.append(firstLink, secondLink, arrow);

    // Append the popover before the btn element
    $(btn).before(popover);
}

window.screenCapture = screenCapture;
window.handleClick = handleClick;
window.stopPresentation = stopPresentation;
window.initializeRoom = initializeRoom;
