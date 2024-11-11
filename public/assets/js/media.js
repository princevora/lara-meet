import { ignoreChange, getPermissions, devicePerms, deviceEnumerate } from './permissions.js';
import { handleMediaEnd, updateMediaUI } from './ui.js';
import { showError, openModal } from './modal.js';

export const preloadImage = (url) => {
    $('<link>', {
        rel: 'preload',
        href: url
    }).appendTo('head');
};

export const toggleMedia = async (media) => {
    try {
        const stream = await navigator.mediaDevices.getUserMedia(media);
        return stream;
    } catch (error) {
        showError('Unable to access media devices.');
    }
};

export const handleGrantedMedia = async (media = 0) => {
    const expectedMedia = media == 0 ? 'mic' : 'camera';

    if (media == 0 && !ignoreChange.mic) {
        await loadSound();
    }

    if (media == 1 && !ignoreChange.camera) {
        await loadVideoSrc()
    }

    const buttons = document.querySelectorAll('.btn-circle');
    buttons[media].onclick = () => toggleMediaUI(media);
    await cookieStore.set(`${expectedMedia}-allowed`, 1);
};

export const loadSound = () => {
    return new Promise(async (resolve, reject) => {
        try {
            const media = { audio: true };
            const stream = await toggleMedia(media);

            // Handle Audio End
            const tracks = stream.getAudioTracks()[0];

            if (devicePerms.mic.hasPerms) {
                devicePerms.mic.tracks = tracks;
                deviceEnumerate(0);
            }

            tracks.onended = () => handleMediaEnd(0);

            // Stop and Resume tracks event handler
            document.addEventListener('stopmicTrack', () => {
                if (tracks.readyState == 'live') {
                    tracks.enabled = false;
                }
            });

            document.addEventListener('resumemicTrack', () => {
                if (tracks.readyState == 'live') {
                    tracks.enabled = true;
                }
            });

            resolve(true);
        } catch (error) {
            reject(false);
        }
    })
        .then(() => updateMediaUI(0))
        .catch(() => showError('Microphone access not granted'));
};

export const loadVideoSrc = (width = 900, height = 450) => {
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

                const tracks = stream.getVideoTracks()[0];
                tracks.onended = () => handleMediaEnd(1, videoElement)

                if (devicePerms.camera.hasPerms) {
                    devicePerms.camera.tracks = tracks;
                    deviceEnumerate(1);
                }

                const videoElement = document.getElementById('videoElement');
                videoElement.srcObject = stream;
                videoElement.play();


                document.addEventListener('stopcameraTrack', () => {
                    if (tracks.readyState == 'live') {
                        tracks.stop();
                        videoElement.srcObject = null;

                        // Change the icons and button
                        if (tracks.readyState == 'ended')
                            handleMediaEnd(1, videoElement);
                    }
                });

                document.addEventListener('resumecameraTrack', async () => {
                    await loadVideoSrc();
                });

                resolve(true);
            } else {
                reject(false);
            }
        } catch {
            reject(false);
        }
    })
        .then(() => updateMediaUI(1))
        .catch(() => {
            $('.heading').removeClass('hidden');
            showError('Camera Access Not Granted');
        })
        .then(() => $('.video-spinner').addClass('d-none'));
};

export const requestMicrophone = async () => {
    const [micState] = await getPermissions();
    ignoreChange.mic = true;

    if (micState !== 'granted' && micState === 'prompt') {
        try {
            await loadSound();
        } catch {
            showError('Microphone access not granted.');
        }
    } else if (micState === 'denied') {
        showError('You have denied microphone permission. Please enable it in site settings.');
    }
};

export const requestCamera = async () => {
    const [, cameraState] = await getPermissions();
    ignoreChange.camera = true;

    if (cameraState !== 'granted' && cameraState === 'prompt') {
        try {
            await loadVideoSrc();
        } catch {
            showError('Camera access not granted.');
        }
    } else if (cameraState === 'denied') {
        showError('You have denied webcam permission. Please enable it in site settings.');
    }
};

export const handleMediaChange = (e, media = 0) => {
    ignoreChange.mic = false;
    ignoreChange.camera = false;

    if (e.currentTarget.state) {
        const state = e.currentTarget.state;
        const btns = document.querySelectorAll('.btn-circle');
        const expectedMedia = media == 0 ? 'mic' : 'camera';

        if (state === 'granted') {
            handleGrantedMedia(media);
            btns[media].onclick = () => toggleMediaUI(media);
        } else if (state === 'denied' || state === 'prompt') {
            $(`#warn-${expectedMedia}`).removeClass('hidden');
            btns[media].onclick = (event) => openModal(event, media);
        }
    }

    if ($('#modal').css('display') !== 'none' && $('#modal').css('opacity') > 0) {
        $('#modal').hide();
    }
};

export const toggleMediaUI = async (media = 0) => {
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

        // Dispatch Event to Resume the audio or webcam
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
