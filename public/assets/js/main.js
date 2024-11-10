import { ignoreChange, getPermissions } from './permissions.js';
import { preloadImage, toggleMedia, handleGrantedMedia, loadSound, loadVideoSrc } from './media.js';
import { updateMediaUI, handleMediaEnd } from './ui.js';
import { showError, openModal } from './modal.js';

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

getPermissions().then(([micState, cameraState]) => {
    if (micState === 'granted') handleGrantedMedia(0);
    else {
        $('.main-icon').eq(0).addClass('hidden');
        $('.forbidden').eq(0).removeClass('hidden');
    }

    if (cameraState === 'granted') handleGrantedMedia(1);
    else {
        $('.main-icon').eq(1).addClass('hidden');
        $('.forbidden').eq(1).removeClass('hidden');
        $('.heading').removeClass('hidden');
    }
});

// Expose openModal globally
window.openModal = openModal;
