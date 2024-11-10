const ignoreChange = {
    mic: false,
    camera: false
};


const preloadImage = (url) => {
    $('<link>', {
        rel: 'preload',
        href: url
    }).appendTo('head');
};

preloadImage(microphoneUrl);
preloadImage(videoUrl);

let micAllowed = 0;
let cameraAllowed = 0;

// Check for browser support of cookieStore
if ('cookieStore' in window) {
    cookieStore.get('mic-allowed').then((value) => micAllowed = value?.value || 0);
    cookieStore.get('camera-allowed').then((value) => cameraAllowed = value?.value || 0);

    cookieStore.addEventListener('change', (event) => {
        event.changed.forEach(cookie => {
            if (cookie.name === 'mic-allowed') {
                micAllowed = cookie.value;
            }
            if (cookie.name === 'camera-allowed') {
                cameraAllowed = cookie.value;
            }
        });
    });
}

const toggleMedia = async (media) => {
    try {
        const stream = await navigator.mediaDevices.getUserMedia(media);
        return stream;
    } catch (error) {
        showError('Unable to access media devices.');
    }
};

const handleGrantedMedia = async (media = 0) => {
    const permsIcons = document.querySelectorAll('.forbidden');
    const buttons = document.querySelectorAll('.btn-circle');
    const expectedMedia = media == 0 ? 'mic' : 'camera';

    if (media == 0 && !ignoreChange.mic) {
        await loadSound();
    }

    if (media == 1 && !ignoreChange.camera) {
        await loadVideoSrc()
        $('.video-spinner').addClass('d-none');
    }

    buttons[media].onclick = () => toggleMediaUI(media);
    await cookieStore.set(`${expectedMedia}-allowed`, 1);
}

const getPermissions = async () => {
    try {
        const micPerms = await navigator.permissions.query({
            name: 'microphone'
        });
        micPerms.onchange = (e) => handleMediaChange(e, 0);

        const cameraPerms = await navigator.permissions.query({
            name: 'camera'
        });

        cameraPerms.onchange = (e) => handleMediaChange(e, 1);

        return [micPerms.state, cameraPerms.state];
    } catch (error) {
        showError("Could not check permissions. Please try again.");
    }
};

/**
 * @param {int} media
*
* the toggleMediaUI expects media parameter to be int
* 0 = microphone
* 1 = camera
*
* every dynamic toggling work will be done with this
*/
const toggleMediaUI = async (media = 0) => {
    const expectedMedia = media == 0 ? 'mic' : 'camera';

    // get current cookie
    const currentValue = await cookieStore.get(`${expectedMedia}-allowed`);

    // Change to string
    const newValue = (Number(currentValue?.value) ^ 1).toString();

    // Set cookie
    await cookieStore.set(`${expectedMedia}-allowed`, newValue);

    // Get microphone and camera permissions
    const [micState, camState] = await getPermissions();

    const expectedVar = media == 0 ? micState : camState;

    const btns = document.querySelectorAll('.btn-circle');

    const dispatchEvent = (event) => {
        // Create Event.
        const customEvent = new CustomEvent(event);

        // Dispatch
        document.dispatchEvent(customEvent);
    }

    if (Number(newValue) === 1 && expectedVar == 'granted') {
        // Resume the audio

        $('.forbidden').eq(media).hide();
        $('.btn-circle').eq(media).removeClass('not-allowed btn-danger').addClass('btn-outline-light');
        $('.main-icon').eq(media).show();

        btns[media].onclick = () => toggleMediaUI(media);


        // Dispatch Event. To Resume the audio or webcame
        dispatchEvent(`resume${expectedMedia}Track`);
    }

    // Stop media
    if (Number(newValue) == 0 && expectedVar == 'granted') {
        dispatchEvent(`stop${expectedMedia}Track`);
    }

    if (expectedVar !== 'granted') {
        btns[media].onclick = (event) => openModal(event, media);
    } else if (Number(newValue) !== 1) {
        $('.btn-circle').eq(media).addClass('not-allowed btn-danger').removeClass('btn-outline-light');
        $('.forbidden').eq(media).show();
        $('.main-icon').eq(media).hide();
    }
};

const handleMediaChange = (e, media = 0) => {
    if (e.currentTarget.state) {
        const state = e.currentTarget.state;
        const btns = document.querySelectorAll('.btn-circle');
        const expectedMedia = media == 0 ? 'mic' : 'camera';

        if (state === 'granted') {

            handleGrantedMedia(media)

            // Toggle media
            btns[media].onclick = () => toggleMediaUI(media);

        } else if (state === 'denied') {
            $(`#warn-${expectedMedia}`).removeClass('hidden');

            // Add onclick on appropriate button
            btns[media].onclick = (event) => openModal(event, media);
        } else if (state === 'prompt') {
            $(`#warn-${expectedMedia}`).removeClass('hidden');
            btns[media].onclick = (event) => openModal(event, media);
        }
    }

    if ($('#modal').css('display') !== 'none' && $('#modal').css('opacity') > 0) {
        $('#modal').hide();
    }
}

getPermissions().then(([micState, cameraState]) => {
    if (micState === 'granted') handleGrantedMedia(0);
    else {

        $('.main-icon').eq(0).addClass('hidden')
        $('.forbidden').eq(0).removeClass('hidden')
    }

    if (cameraState === 'granted') handleGrantedMedia(1);
    else {
        $('.main-icon').eq(1).addClass('hidden')
        $('.forbidden').eq(1).removeClass('hidden')
        $('.heading').removeClass('hidden');
    }

});

const updateMediaUI = (media) => {
    const permsIcons = document.querySelectorAll('.forbidden');
    const buttons = document.querySelectorAll('.btn-circle');
    const expectedMedia = media == 0 ? 'mic' : 'camera';

    // Update the button and icon for microphone access
    $(buttons[media]).removeClass('not-allowed btn-danger').addClass('btn-outline-light')
    // .addClass('btn-primary');
    $(permsIcons[media]).addClass('hidden');

    // Show main icon
    $('.main-icon').eq(media).removeClass('hidden');

    // Hide any warning for microphone access
    $(`#warn-${expectedMedia}`).addClass('hidden');
};

const requestMicrophone = async () => {
    const [micState] = await getPermissions();
    ignoreChange.mic = true;

    if (micState !== 'granted' && micState === 'prompt') {
        try {
            await loadSound()
        } catch {
            showError('Microphone access not granted.');
        }
    } else if (micState === 'denied') {
        showError('You have denied microphone permission. Please enable it in site settings.');
    }
};


const requestCamera = async () => {
    const [, cameraState] = await getPermissions();
    ignoreChange.camera = true;

    if (cameraState !== 'granted' && cameraState === 'prompt') {
        try {
            await loadVideoSrc()
        } catch {
            $('.heading').removeClass('hidden');

            showError('Camera access not granted.');
        }
    } else if (cameraState === 'denied') {
        showError('You have denied webcam permission. Please enable it in site settings.');
    }
};

const loadVideoSrc = (width = 900, height = 450) => {

    return new Promise(async (resolve, reject) => {
        try {
            const media = {
                video: {
                    facingMode: 'environment',
                    width,
                    height
                }
            };
            $('.video-spinner').removeClass('d-none');
            $('.heading').addClass('hidden');

            const stream = await toggleMedia(media);

            if (stream !== undefined) {

                $('#warn-camera').addClass('hidden');

                const videoElement = document.getElementById('videoElement');
                videoElement.srcObject = stream;
                videoElement.play();

                const tracks = stream.getVideoTracks()[0];
                tracks.onended = () => handleMediaEnd(1, videoElement);

                $('#videoElement').on('loadedmetadata', () => {
                    $('#closeModal').click();
                });

                // Stop tracks. event handler
                document.addEventListener('stopcameraTrack', () => {
                    if (tracks.readyState == 'live') {
                        tracks.stop();

                        videoElement.srcObject = null;

                        // Change the icons and button
                        if (tracks.readyState == 'ended')
                            handleMediaEnd(1, videoElement);
                    }
                })

                // Resume tracks event handler
                document.addEventListener('resumecameraTrack', async () => {
                    // Resume the camera
                    await loadVideoSrc()
                })

                resolve(true);
            } else {
                reject(false);
            }

            $('.video-spinner').addClass('d-none');

        } catch {
            reject(false);
        }
    })
        .then(() => updateMediaUI(1))
        .catch(() => {
            $('.heading').removeClass('hidden');
            showError('Camera Access Not Granted');
        });
};

// videoElement
const handleMediaEnd = (media = 0, videoElement = null) => {
    const expectedMedia = media == 0 ? 'mic' : 'camera';

    if (media == 1) {
        videoElement.srcObject = null;

        $('.heading').removeClass('hidden').text('The webcam was disabled');
    }

    cookieStore.set(`${expectedMedia}-allowed`, 0);

    const permsIcons = document.querySelectorAll('.forbidden');
    const buttons = document.querySelectorAll('.btn-circle');

    // Update the button and icon for microphone access
    $(buttons[media]).addClass('not-allowed btn-danger').removeClass('btn-outline-light')
    // .addClass('btn-primary');

    $(permsIcons[media]).removeClass('hidden');

    // Show main icon
    $('.main-icon').eq(media).addClass('hidden');

    // Hide any warning for microphone access
    $(`#warn-${expectedMedia}`).removeClass('hidden');
}

const loadSound = () => {
    return new Promise(async (resolve, reject) => {
        try {
            const media = {
                audio: true
            };

            const stream = await toggleMedia(media);
            
            console.log(stream.getAudioTracks()[0]);
            

            // Set cookies
            await cookieStore.set('mic-allowed', 1);

            // Handle Audio End
            const tracks = stream.getAudioTracks()[0];

            tracks.onended = () => handleMediaEnd(0);

            // Stop tracks. event handler
            document.addEventListener('stopmicTrack', () => {
                if (tracks.readyState == 'live') {
                    tracks.enabled = false

                }
            })

            // Resume tracks event handler
            document.addEventListener('resumemicTrack', () => {
                if (tracks.readyState == 'live') {
                    // Resume the tracks
                    tracks.enabled = true
                }
            })

            resolve(true);
        } catch (error) {
            reject(false);
        }
    })
    .then(() => updateMediaUI(0))
    .catch(() => showError('Microphone access not granted'));
};


const showError = (message) => {
    $('#error-context').removeClass('hidden').text(message);
};

const openModal = (event, type) => {
    const modalData = {
        0: {
            heading: 'Let people hear what you say.',
            desc: 'To talk, please enable your microphone for audio input.',
            src: microphoneUrl,
            buttonText: 'Enable Microphone',
            onClick: requestMicrophone
        },
        1: {
            heading: 'Talk live with people using webcam.',
            desc: 'Enable webcam to talk live.',
            src: videoUrl,
            buttonText: 'Enable Webcam',
            onClick: requestCamera
        }
    };

    const data = modalData[type];
    $('#modal-heading').text(data.heading);
    $('#modal-desc').text(data.desc);
    $('#modal-image').attr('src', data.src);
    $('#mediaButton').text(data.buttonText).off('click').on('click', data.onClick);
    $('#modal').css('display', 'flex').removeClass('opacity-0 pointer-events-none');
    setTimeout(() => $('#modal > div').removeClass('scale-95'), 10);
};

$('#closeModal').on('click', () => {
    $('#modal').addClass('opacity-0 pointer-events-none');
    $('#modal > div').addClass('scale-95');
    $('#error-context').text('');
    setTimeout(() => $('#modal').hide(), 200);
});

$(document).on('click', (e) => {
    if ($(e.target).is('#modal')) {
        $('#closeModal').click();
    }
})