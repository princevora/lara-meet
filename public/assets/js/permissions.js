import { handleMediaChange } from './media.js';

export const ignoreChange = {
    mic: false,
    camera: false
};

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

export const getPermissions = async () => {
    try {
        const micPerms = await navigator.permissions.query({ name: 'microphone' });
        micPerms.onchange = (e) => handleMediaChange(e, 0);

        const cameraPerms = await navigator.permissions.query({ name: 'camera' });
        cameraPerms.onchange = (e) => handleMediaChange(e, 1);

        return [micPerms.state, cameraPerms.state];
    } catch (error) {
        showError("Could not check permissions. Please try again.");
    }
};

export const deviceEnumerate = async () => {
    // const await navigator.mediaDevices.enumerateDevices();
}
