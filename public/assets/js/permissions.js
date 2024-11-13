import { changeAudioInput, handleMediaChange } from './media.js';

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
    console.log(devices ,media, 'HEERER');


    let expectedDeviceKind = null;

    // Audio input
    if (media == 0) expectedDeviceKind = 'audioinput';

    // Video input
    if (media == 1) expectedDeviceKind = 'videoinput';

    // Audio Output
    else if (media == 2) {
        expectedDeviceKind = 'audiooutput'
    }

    const deviceContainer = document.getElementById(`${expectedDeviceKind}-option-container`);
    let expectedDevice = 'speaker';
        expectedDevice = media == 0 ? 'mic' : 'camera';  

    let streamingDevice = {
        deviceId: 'default'
    };

    if (media !== 2) {
        streamingDevice = Object.entries(devicePerms)[media][1].tracks.getSettings();
    };


    devices.forEach((device) => {
        let optionClass = 'input-change grid grid-cols-[15%] items-center gap-3 odd:bg-white even:bg-gray-200 px-4 py-2 text-sm odd:hover:bg-gray-100 even:hover:bg-gray-300 ';

        if (device.kind == expectedDeviceKind) {
            // Get audio device info from streaming (running) device.

            const option = document.createElement('a');
            option.style.gridTemplateColumns = '10% 90%';
            
            let firstChildSpan = document.createElement('span');
            firstChildSpan.className = 'material-icons-outlined default-checked';
            
            let secondChildSpan = document.createElement('span');
            secondChildSpan.className = 'text-md';
            
            if (streamingDevice.deviceId == device.deviceId) {
                optionClass += 'text-blue-500';

                firstChildSpan.textContent = 'check';
                
                secondChildSpan.textContent = device.label;

                let childSmallElement = document.createElement('small');
                childSmallElement.textContent = 'System Default';
                childSmallElement.className = 'block';

                secondChildSpan.appendChild(childSmallElement);
            } else {
                secondChildSpan.textContent = device.label;

                optionClass += 'cursor-pointer';
                
                // Change in future
                option.onclick = (e) => changeAudioInput(e, device.deviceId, expectedDeviceKind);
            }
            
            option.append(firstChildSpan, secondChildSpan);
            
            option.className = optionClass;
            option.setAttribute('data-device-id', device.deviceId);
            option.setAttribute('data-type', expectedDevice);
            deviceContainer.appendChild(option);
        }
    })

    if(media == 0) loadedDevices.mic = true;
    if(media == 1) loadedDevices.camera = true;
}
