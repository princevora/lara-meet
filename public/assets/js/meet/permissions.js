import { changeDevice, handleMediaChange } from './media.js';

export const ignoreChange = {
    mic: false,
    camera: false
};

export const devicePerms = {
    mic: {
        tracks: null,
        hasPerms: false
    },
    camera: {
        tracks: null,
        hasPerms: false
    },
};

export const defaultDevice = {
    mic: null,
    camera: null,
    spaker: null
}

// Will be used for enumerate device.
export const loadedDevices = {
    mic: false,
    camera: false
}

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

        if (micPerms.state == 'granted') devicePerms.mic.hasPerms = true;
        if (cameraPerms.state == 'granted') devicePerms.camera.hasPerms = true;


        return [micPerms.state, cameraPerms.state];
    } catch (error) {
        console.error("Could not check permissions. Please try again.");
    }
};

/**
 * 
 * @param {number} media 
 */
export const deviceEnumerate = async (media = 0) => {
    const devices = await navigator.mediaDevices.enumerateDevices();

    if (media == 2 || Object.entries(devicePerms)[media][1])
        listMediaDevicesUI(devices, media)
}

/**
 * 
 * @param {MediaDevices} devices 
 * @param {number} medaia 
 */
export const listMediaDevicesUI = (devices, media = 0) => {

    let expectedDeviceKind = getExpectedDeviceKind(media);

    const deviceContainer = document.getElementById(`${expectedDeviceKind}-option-container`);
    let expectedDevice = media == 0 ? 'mic' : (media == 1 ? 'camera' : 'speaker');
    
    let streamingDevice = {
        deviceId: 'default'
    };

    if (media !== 2) {
        streamingDevice = Object.entries(devicePerms)[media][1].tracks.getSettings();
    };


    devices.forEach((device) => {
        let optionClass = 'input-change grid grid-cols-[15%] items-center text-start gap-3 odd:bg-white even:bg-gray-200 px-4 py-2 text-sm odd:hover:bg-gray-100 even:hover:bg-gray-300 ';

        if (device.kind == expectedDeviceKind) {
            // Get audio device info from streaming (running) device.

            const option = document.createElement('button');
            option.style.gridTemplateColumns = '10% 90%';

            let firstChildSpan = document.createElement('span');
            firstChildSpan.className = 'material-icons-outlined default-checked';

            let secondChildSpan = document.createElement('span');
            secondChildSpan.className = 'text-md';

            secondChildSpan.textContent = device.label;

            if (streamingDevice.deviceId == device.deviceId) {
                defaultDevice[expectedDevice] = device.deviceId;

                optionClass += 'text-blue-500';

                firstChildSpan.textContent = 'check';

                let childSmallElement = document.createElement('small');
                childSmallElement.textContent = 'System Default';
                childSmallElement.className = 'block';

                option.disabled = true;

                secondChildSpan.appendChild(childSmallElement);
            } else {

                // Change in future
                option.onclick = (e) => changeDevice(e, device.deviceId, expectedDeviceKind, media);
            }

            option.append(firstChildSpan, secondChildSpan);

            option.className = optionClass;
            option.setAttribute('data-device-id', device.deviceId);
            option.setAttribute('data-type', expectedDevice);
            deviceContainer.appendChild(option);
        }
    })

    if (media == 0) loadedDevices.mic = true;
    if (media == 1) loadedDevices.camera = true;
}

export const getExpectedDeviceKind = (media) => {
    // Audio input
    if (media == 0) return 'audioinput';

    // Video input
    else if (media == 1) return 'videoinput';

    // Audio Output
    else if (media == 2) return 'audiooutput'
}

export const getExpectedDevice = (media) => {
    // Audio input
    if (media == 0) return 'mic';
    
    // Audio Output
    else if (media == 2) return 'speaker';
    
    // Video input
    else if (media == 1) return 'camera';
    
}