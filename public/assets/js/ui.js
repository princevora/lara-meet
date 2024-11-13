import { handleGrantedMedia, toggleMedia, loadSound, loadVideoSrc } from './media.js';
import { getPermissions } from './permissions.js';
import { openModal } from './modal.js';
import { modifyButton } from './main.js';

export const ignores = {
    mic: {warn: false},
    camera: {warn: false}
};

export const updateMediaUI = (media) => {
    const permsIcons = document.querySelectorAll('.forbidden');
    const buttons = document.querySelectorAll('.btn-circle');
    const expectedMedia = media == 0 ? 'mic' : 'camera';

    $(buttons[media]).removeClass('not-allowed btn-danger').addClass('btn-outline-light');
    $(permsIcons[media]).addClass('hidden');
    $('.main-icon').eq(media).removeClass('hidden');
    $(`#warn-${expectedMedia}`).addClass('hidden');
};

export const handleMediaEnd = (media = 0, videoElement = null) => {
    const expectedMedia = media == 0 ? 'mic' : 'camera';
    const expectedDevice = media == 0 ? 'microphone' : 'camera';

    if (media == 1) {
        videoElement.srcObject = null;
        $('.heading').removeClass('hidden');
    }

    cookieStore.set(`${expectedMedia}-allowed`, 0);

    const permsIcons = document.querySelectorAll('.forbidden');
    const buttons = document.querySelectorAll('.btn-circle');

    $(buttons[media]).addClass('not-allowed btn-danger').removeClass('btn-outline-light');
    $(permsIcons[media]).removeClass('hidden');
    
    $('.main-icon').eq(media).addClass('hidden');
    
    if(!ignores.camera.warn) {
        $(`#warn-${expectedMedia}`).removeClass('hidden');
    }

    // Disabled media change dropdown
    modifyButton(false, expectedDevice);
};
