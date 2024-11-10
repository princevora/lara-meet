import { handleGrantedMedia, toggleMedia, loadSound, loadVideoSrc } from './media.js';
import { getPermissions } from './permissions.js';
import { openModal } from './modal.js';

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

    if (media == 1) {
        videoElement.srcObject = null;
        $('.heading').removeClass('hidden').text('The webcam was disabled');
    }

    cookieStore.set(`${expectedMedia}-allowed`, 0);

    const permsIcons = document.querySelectorAll('.forbidden');
    const buttons = document.querySelectorAll('.btn-circle');

    $(buttons[media]).addClass('not-allowed btn-danger').removeClass('btn-outline-light');
    $(permsIcons[media]).removeClass('hidden');
    $('.main-icon').eq(media).addClass('hidden');
    $(`#warn-${expectedMedia}`).removeClass('hidden');
};
