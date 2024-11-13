import { ignoreChange, getPermissions, devicePerms, deviceEnumerate, loadedDevices, defaultDevice, getExpectedDeviceKind, getExpectedDevice } from './permissions.js';
import { handleMediaEnd, ignores, updateMediaUI } from './ui.js';
import { showError, openModal } from './modal.js';
import { modifyButton } from './main.js';

export const deviceConfig = {
    mic: { stream: null },
    camera: { stream: null },
    speaker: { stream: null },
}

export const loadEnumerateDevice = {
    mic: false,
    speaker: false,
    camera: false
}

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

export const loadSound = (changeTrack = false, deviceId = null) => {
    // Disable The main toggle button untill the sound is loaded or refused to load.
    $('.btn-circle').eq(0).attr('disabled', true);

    return new Promise(async (resolve, reject) => {
        try {
            const media = { audio: true };

            if (changeTrack && deviceId !== null) {
                media.audio = {
                    deviceId: { exact: deviceId }
                }
            }

            const stream = await toggleMedia(media);
            devicePerms.mic.hasPerms = true;

            // const s = document.getElementById('constau');
            // s.srcObject = stream

            deviceConfig.mic.stream = stream;

            // Handle Audio End
            const tracks = stream.getAudioTracks()[0];

            if (devicePerms.mic.hasPerms && !loadEnumerateDevice.mic) {
                devicePerms.mic.tracks = tracks;
                if (!loadedDevices.mic) {
                    deviceEnumerate(0);

                    if (!loadEnumerateDevice.speaker) {
                        // Load speaker Device.
                        deviceEnumerate(2);
                    }

                    // Dont load devices again
                    loadEnumerateDevice.mic = true;
                    loadEnumerateDevice.speaker = true;
                }
            }

            tracks.onended = () => handleMediaEnd(0);

            // Stop and Resume tracks event handler
            document.addEventListener('stopmicTrack', () => {
                if (tracks.readyState == 'live') {
                    tracks.enabled = false;
                }
            });

            document.addEventListener('disablemicTrack', () => {
                if (tracks.readyState == 'live') {
                    tracks.stop();
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
        .catch(() => showError('Microphone access not granted'))
        .finally(() => $('.btn-circle').eq(0).attr('disabled', false));
};

/**
 * 
 * @param {Event} e 
 * @param {string} deviceId 
 * @param {string} deviceKind 
 */
export const changeAudioInput = (e, deviceId, deviceKind, type) => {
    e.preventDefault();
    const expectedDeviceKind = getExpectedDeviceKind(type);
    const expectedDevice = getExpectedDevice(type);

    if (deviceConfig[expectedDevice].stream) {
        // Stop the previous track.
        dispatchEvent(`disable${expectedDevice}Track`);

        // reload The Audio Input
        loadSound(true, deviceId);

        $(`*[data-type=${expectedDevice}]`).attr('disabled', false);

        const defaultOption = document.querySelector(`*[data-type=${expectedDevice}][data-device-id="${defaultDevice.mic}"]`);
        if (!defaultOption.onclick) {
            defaultOption.onclick = (e) => changeAudioInput(e, defaultDevice.mic, deviceKind, type);
        }

        // Set the text empty of the material icon
        $(`*[data-type=${expectedDevice}] .default-checked`).each((index, element) => {
            element.textContent = null;
        })

        console.log(document.querySelector(`*[data-type=${expectedDevice}][data-device-id="${deviceId}"]`), deviceId);


        // streamingDevice = Object.entries(devicePerms)[media][1].tracks.getSettings();

        // Remove blue color
        $(`*[data-type=${expectedDevice}].text-blue-500`).each((index, element) => {
            $(element).removeClass('text-blue-500');
        })

        // Find first span to use material icon (check icon)
        $(`[data-type=${expectedDevice}][data-device-id="${deviceId}"] span:first-child`)
            .text('check')
            .each(function () {
                if (!$(this).hasClass('default-checked')) {
                    $(this).addClass('default-checked');
                }
            });


        // find perticula option with same device id and add blue color
        const selectedOption = $(`[data-type=${expectedDevice}][data-device-id="${deviceId}"]`);
        $(selectedOption).attr('disabled', true);
        $(selectedOption).addClass('text-blue-500');
    }
}

export const loadVideoSrc = (width = 900, height = 450) => {
    $('.btn-circle').eq(1).attr('disabled', true)

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

                devicePerms.camera.hasPerms = true;

                if (devicePerms.camera.hasPerms && !loadEnumerateDevice.camera) {
                    devicePerms.camera.tracks = tracks;
                    if (!loadedDevices.camera) {
                        deviceEnumerate(1);

                        // Dont load devices again
                        loadEnumerateDevice.camera = true;
                    }
                }

                const videoElement = document.getElementById('videoElement');
                videoElement.srcObject = stream;
                videoElement.play();


                document.addEventListener('stopcameraTrack', () => {
                    if (tracks.readyState == 'live') {
                        // Disable previous track
                        disabledTrack();

                        videoElement.srcObject = null;

                        // Change the icons and button
                        if (tracks.readyState == 'ended') {
                            ignores.camera.warn = true;

                            handleMediaEnd(1, videoElement);

                            // Reset backs the state
                            ignores.camera.warn = false;
                        }
                    }
                });

                const disabledTrack = () => {
                    return tracks.stop();
                }
                document.addEventListener('disablecameraTrack', () => {
                    if (tracks.readyState == 'live') {
                        disabledTrack();
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
        .then(() => $('.video-spinner').addClass('d-none'))
        .catch(() => {
            $('.heading').removeClass('hidden');
            showError('Camera Access Not Granted');
        })
        .finally(() => $('.btn-circle').eq(1).attr('disabled', false));
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
        const expectedDevice = media == 0 ? 'microphone' : 'camera';

        if (state === 'granted') {
            handleGrantedMedia(media);
            modifyButton(true, expectedDevice)

            btns[media].onclick = () => toggleMediaUI(media);
        } else if (state === 'denied' || state === 'prompt') {
            modifyButton(false, expectedDevice)
            $(`#warn-${expectedMedia}`).removeClass('hidden');
            btns[media].onclick = (event) => openModal(event, media);
        }
    }

    if ($('#modal').css('display') !== 'none' && $('#modal').css('opacity') > 0) {
        $('#modal').hide();
    }
};

const dispatchEvent = (event) => {
    // Create Event.
    const customEvent = new CustomEvent(event);

    // Dispatch
    document.dispatchEvent(customEvent);
}

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

    console.log("MEDIA IS: ", media);


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