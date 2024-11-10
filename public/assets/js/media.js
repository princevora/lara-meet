import { ignoreChange, getPermissions } from './permissions.js';
import { updateMediaUI, handleMediaEnd } from './ui.js';
import { showError } from './modal.js';

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
                const videoElement = document.getElementById('videoElement');
                videoElement.srcObject = stream;
                videoElement.play();

                const tracks = stream.getVideoTracks()[0];
                tracks.onended = () => handleMediaEnd(1, videoElement);

                document.addEventListener('stopcameraTrack', () => {
                    if (tracks.readyState == 'live') {
                        tracks.stop();
                        videoElement.srcObject = null;
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
