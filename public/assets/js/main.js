import { deviceEnumerate, devicePerms, getPermissions, listMediaDevicesUI } from './permissions.js';
import { preloadImage, handleGrantedMedia, } from './media.js';
import { openModal } from './modal.js';

preloadImage(microphoneUrl);
preloadImage(videoUrl);

const toggleMediaUI = async (media = 0) => {
    const expectedMedia = media == 0 ? 'mic' : 'camera';
    const currentValue = await cookieStore.get(`${expectedMedia}-allowed`);
    const newValue = (Number(currentValue?.value) ^ 1).toString();

    await cookieStore.set(`${expectedMedia}-allowed`, newValue);
    const [micState, camState] = await getPermissions();
    const expectedVar = media == 0 ? micState : camState;
    const btns = document.querySelectorAll('.btn-circle');
    const dispatchEvent = (event) => {
        const customEvent = new CustomEvent(event);
        document.dispatchEvent(customEvent);
    };

    if (Number(newValue) === 1 && expectedVar == 'granted') {
        $('.forbidden').eq(media).hide();
        $('.btn-circle').eq(media).removeClass('not-allowed btn-danger').addClass('btn-outline-light');
        $('.main-icon').eq(media).show();
        btns[media].onclick = () => toggleMediaUI(media);
        dispatchEvent(`resume${expectedMedia}Track`);
    }

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

const modifyButton = (enable = true, device) => {
    // Enable deviceKind dropdowns of perticular div. 
    // when the device media stat is granted
    const micDeviceKinds = $(`div[data-device-related="${device}"]`);
    $(micDeviceKinds).each((index, element) => {
        if ($(element).children().is('button')) {
            $(element).children().attr('disabled', !enable)
        }
    })
}

getPermissions().then(async ([micState, cameraState]) => {
    await navigator.mediaDevices.enumerateDevices().then(devices => listMediaDevicesUI(devices, 2));
    const deviceKinds = $('div[data-device-related]');

    if (micState === 'granted') {
        modifyButton(true, 'microphone');
        handleGrantedMedia(0);
    }
    else {
        $('.main-icon').eq(0).addClass('hidden');
        $('.forbidden').eq(0).removeClass('hidden');
    }

    if (cameraState === 'granted') {
        modifyButton(true, 'camera');
        handleGrantedMedia(1);
    }
    else {
        $('.main-icon').eq(1).addClass('hidden');
        $('.forbidden').eq(1).removeClass('hidden');
        $('.heading').removeClass('hidden');
    }
});

// Expose openModal globally
window.openModal = openModal;