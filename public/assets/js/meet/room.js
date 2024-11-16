const btn = $('#screen-capture');
let popoverOpenable = false;

const popoverBtn = document.getElementById('screen-capture');

// Initialize the button onclick event.
popoverBtn.onclick = screenCapture;

async function screenCapture() {
    // Make the Button disabled
    $(btn).attr('disabled', true);

    await getDisplay()
        .then((stream) => {

            // Make the button to toggle the screens
            togglePopOverAttr();

            // Remove the button's focus (this should work)
            $(btn).blur();

            popoverOpenable = true;
            popoverBtn.onclick = handleClick;

            // Update button UI (ensure these changes are applied after promise resolves)
            $(btn)
                .removeClass('bg-gray-700 hover:bg-gray-800')
                .addClass('bg-blue')
                .removeClass('hover:bg-gray-800') // Ensure no hover effect with the new class
                .blur();

            // Handle stream end
            stream.getVideoTracks()[0].onended = handleScreenEnd;
        })
        .catch((err) => console.log('Permission Denied'))

    // Enable the button
    .finally(() => $(btn).attr('disabled', false));
}

const handleClick = (e) => {
    console.log(popoverOpenable);

    if (!popoverOpenable) {
        popoverBtn.onclick = screenCapture;
    } else if (popoverOpenable) {
        console.log('here');
        e.stopPropagation();

        const popoverElement = document.getElementById('popover-click');

        // Initialize popover using Flowbite (only if needed; Flowbite's default data attributes should be enough)
        const popover = new Popover(popoverElement, popoverBtn, {
            triggerType: 'click',
            placement: 'bottom',
        });

        // Show popover
        popover.show();
    }
}

const togglePopOverAttr = () => {
    $(btn).attr('data-popover-target', (_, attr) => attr ? null : 'popover-click');
    $(btn).attr('data-popover-trigger', (_, attr) => attr ? null : 'click');
};

const getAudioTracks = () => { };

const getDisplay = () => {
    return new Promise((resolve, reject) => {
        try {
            // get screen
            const stream = navigator.mediaDevices.getDisplayMedia({ audio: true });

            // Resolve stream 
            resolve(stream);

        } catch (error) {
            reject(false);
        }
    })
}

const handleScreenEnd = () => {
    $(btn)
        .addClass('bg-gray-700 hover:bg-gray-800') // Reset the button styles after screen capture ends
        .removeClass('bg-blue');
}

window.screenCapture = screenCapture;
window.handleClick = handleClick;
