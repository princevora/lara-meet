import { initializeMediaDevices } from './main.js';

let stream = null;
let popover;
let popoverOpenable = false;
let peer_ids = [];
let micStream, cameraStream;
const btn = $('#screen-capture');
const popoverBtn = document.getElementById('screen-capture');
const url = "stun:stun.l.google.com:19302";
const peerConfig = {
    config: {
        iceServers: [
            { url }
        ]
    }
};

const peer = new Peer(peerConfig);

const callPeers = (peer_id = null) => {
    if (peer_id !== null) {
        if(micStream) {
            peer.call(peer_id, micStream);
        }
        if(cameraStream) {
            peer.call(peer_id, cameraStream);
        }
    } else {
        peer_ids.forEach(user => {
            if(micStream) {
                peer.call(user.peer_id, micStream);
            }
            if(cameraStream) {
                peer.call(user.peer_id, cameraStream);
            }
        })
    }
}

export function broadcastMedia (media, streams) {
    [micStream, cameraStream] = streams;
    
    callPeers();
}

function initializeRoom() {
    peer.on('open', peer_id => {
        // this will help to broadcast our peer id to others so they can call us.
        Livewire.dispatch('add-user-to-room', { peer_id });
    })

    peer.on('call', call => {
        let _remoteStream;
        call.answer();

        call.on('stream', remoteStream => {
            _remoteStream = remoteStream;

            identifyStreamType(remoteStream);
        })

        // call.on('close', () => {

        // const audio = document.getElementsByTagName('audio');
        // if (audio) audio.remove();

        // // Remove video element if it exists
        // const video = document.getElementsByTagName('video');
        // if (video) video.remove();
        // });
    })

    const handleRemoteCameraStream = (stream) => {
        const video = document.createElement('video');
        video.srcObject = stream;
        video.id = "test";
        video.autoplay = true;
        video.muted = true; // helpful for autoplay
        video.playsInline = true;

        video.play().catch(err => {
            console.error('Playback failed:', err);
        });

        document.body.appendChild(video);
    }

    const handleRemoteAudioStream = (stream) => {
        const audio = document.createElement('audio');
        audio.srcObject = stream;
        audio.muted = true;
        audio.autoplay = true;
        audio.playsInline = true;
        document.body.appendChild(audio);

        audio.muted = false;
        audio.play();
    }

    const identifyStreamType = (stream) => {
        const callbacks = {
            video: handleRemoteCameraStream,
            audio: handleRemoteAudioStream
        }

        for (const track of stream.getTracks()) {
            if (track && callbacks[track.kind]) {
               return callbacks[track.kind](stream);
            }
        }
    }

    document.addEventListener('event:peer-joined', ({ detail: { user } }) => {
        console.log('JOined');

        const user_peer = {
            id: user.user_id,
            peer_id: user.peer_id
        }

        // store in the frontend - temporary to access real time users
        peer_ids.push(user_peer);

        // call the peer when joins
        callPeers(user.peer_id);
    });

    // Listen for the frontend event when the alpine will be fully initiazlied

    if (Alpine == undefined || Livewire == undefined || Echo == undefined)
        return;

    document.addEventListener('existing-members', async (event) => {
        [micStream, cameraStream] = await initializeMediaDevices(false);

        waitForAlpineInit(() => {

            const data = event.detail[0];
            const instance = window.roomMembersInstance;
            const users = instance.users;
            const room_id = instance.room;

            document.addEventListener('event:peer-left', ({ detail: { user } }) => {
                peer_ids = peer_ids.filter(u => {
                    return u.id !== user.id;
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
popoverBtn.onclick = screenCapture;

// document.addEventListener('DOMContentLoaded', async () => {
//     const { getPermissions } = await import('./permissions.js'); // Lazy import
//     const { deviceConfig, dispatchEvent } = await import('./media.js'); // Lazy import
//     const [micState, cameraState] = await getPermissions();

//     if (cameraState == 'granted') {
//         document.addEventListener('roomProfile', (e) => {
//         });
//     }

//     if (micState == 'granted') {
//         const broadcastAudio = dispatchEvent('broadcastAudio');
//     }
// });

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
