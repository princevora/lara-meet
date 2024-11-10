import MediaNavigator from "./media-navigator.js";

class MediaUIHandler extends MediaNavigator {

    constructor() {
        super();

        this.element = null;

        this.modalData = {
            0: {
                heading: 'Let people hear what you say.',
                desc: 'To talk, please enable your microphone for audio input.',
                src: microphoneUrl,
                buttonText: 'Enable Microphone',
                onClick: this.requestMicrophone
            },
            1: {
                heading: 'Talk live with people using webcam.',
                desc: 'Enable webcam to talk live.',
                src: videoUrl,
                buttonText: 'Enable Webcam',
                onClick: this.requestCamera
            }
        }
    }

    /**
     * 
     * @param {number} media 
     */
    handleGrantedMedia(media = 0) {
        // Remove class

        window.addEventListener('load', async () => {
            
            console.log(this.loaded);

            console.log(this.buttons);
            console.log(this.permsIcons);

            this.modifyClass(this.buttons[media])
                .removeClass('not-allowed btn-danger')
                .addClass('btn-primary')

            // Add classes
            this.addClass('hidden', this.permsIcons[media]);
            this.addClass('hidden', document.getElementById('warn-mic'));

            if (media == 0) {
                // Load sound.
                await this.loadSound();

                return;
            }

            else if (media == 1) {
                // Load video
                this.loadVideo();

                // Add d-none class
                this.addClass('d-none', document.querySelector('.video-spinner'))

                return;
            }
        })
    }

    /**
     * 
     * @param {Event} event 
     * @param {number} type 
     */
    openModal(event, type) {
        const data = this.modalData[type];

        document.getElementById('modal-heading').textContent = data.heading;
        document.getElementById('modal-desc').textContent = data.desc;
        document.getElementById('modal-image').setAttribute('src', data.src);
        const mediaButton = document.getElementById('mediaButton');

        mediaButton.textContent = data.buttonText;
        mediaButton.addEventListener('click', data.onClick.bind(this)); // Add new click event listener

        const modal = document.getElementById('modal');
        modal.style.display = 'flex';
        modal.classList.remove('opacity-0', 'pointer-events-none');
    }

    async requestMicrophone() {

        await this.permissionQuery.getPermission();

        // Get microphone permissions
        const { state } = this.permissionQuery.getCurrentPermissions().microphone;

        if (state !== 'granted' && state === 'prompt') {
            try {
                await this.loadSound();

                // Update appropritate ui
                this.updateMicrophoneUI();

                await cookieStore.set('mic-allowed', 1);

                // Click to close modal automatically.
                document.getElementById('closeModal').click();
            } catch (error) {
                console.log('error', error);

                this.permissionQuery.showError('Microphone access not granted.');
            }
        } else if (state === 'denied') {
            this.permissionQuery.showError('You have denied microphone permission. Please enable it in site settings.');
        }
    }

    async requestCamera() {
        await this.permissionQuery.getPermission();

        // Get microphone permissions
        const { state } = this.permissionQuery.getCurrentPermissions().camera;

        if (state !== 'granted' && state == 'prompt') {
            return this.handleGrantedMedia(1);
        } else if (state === 'denied') {
            this.permissionQuery.showError('You have denied webcam permission. Please enable it in site settings.');
        }
    }

    updateMicrophoneUI() {
        window.addEventListener('load', () => {
            // Update the button and icon for microphone access
            this.modifyClass(this.buttons[0]).removeClass('not-allowed btn-danger').addClass('btn-primary');
            this.modifyClass(this.permsIcons[0]).addClass('hidden')
    
            // Hide any warning for microphone access
            this.addClass(document.getElementById('warn-mic')).addClass('hidden');
        })
    }
}

export default MediaUIHandler;