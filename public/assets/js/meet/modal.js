import { requestMicrophone, requestCamera } from './media.js';

export const showError = (message) => {
    $('#error-context').removeClass('hidden').text(message);
};

export const openModal = (event, type) => {
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
});
