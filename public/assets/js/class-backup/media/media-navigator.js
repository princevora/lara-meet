import PermissionQuery from "../permissions/permision-query.js";
import MediaHandler from "./media-handler.js";

class MediaNavigator {

    static buttons = [];
    static permsIcons = [];

    constructor() {
        this.mediaHandler = new MediaHandler();
        this.loaded = 0;
    
        window.addEventListener('load', () => {
            const permissionElements = document.querySelectorAll('permission-element');

            permissionElements.forEach(permissionElement => {
                const shadowRoot = permissionElement.shadowRoot;

                if (shadowRoot) {
                    MediaNavigator.buttons.push(shadowRoot.querySelector('.btn-circle'));
                    MediaNavigator.permsIcons.push(shadowRoot.querySelector('.forbidden-icon'));
                }
            });

            this.loaded = 1
        });

        this._permissionQuery = null;
        this.stream = null;
    }

    get buttons() {
        if(this.loaded == 1) {
            return MediaNavigator.buttons;
        }
    }

    get permsIcons() {
        if(this.loaded == 1) {
            return MediaNavigator.permsIcons;
        }
    }

    // Lazy initialize PermissionQuery
    get permissionQuery() {
        if (!this._permissionQuery) {
            this._permissionQuery = new PermissionQuery();
        }
        return this._permissionQuery;
    }

    async loadSound() {
        try {
            const media = {
                audio: true
            };

            const rsp = await this.mediaHandler.toggleMedia(media);

            if (rsp.error == 0) {
                const { stream } = rsp;

                // Handle Audio End
                const tracks = stream.getAudioTracks()[0];

                tracks.onended = () => this.mediaHandler.handleMediaEnd(0);
                this.configureSoundEventListeners(stream);
            }

            else {
                throw rsp.error;
            }

        } catch (error) {
            console.log(error);

            this.permissionQuery.showError('Microphone access not granted.');
        }
    }

    configureSoundEventListeners(stream) {
        if (stream) {
            const tracks = stream.getAudioTracks()[0];

            // Stop tracks. event handler
            document.addEventListener('stopmicTrack', () => {
                if (tracks.readyState == 'live') {
                    tracks.enabled = false
                }
            })

            // Resume tracks event handler
            document.addEventListener('resumemicTrack', () => {
                if (tracks.readyState == 'live') {
                    // Resume the tracks
                    tracks.enabled = true
                }
            })
        }
    }

    configureCameraEventListeners(stream) {
        if (stream) {
            const tracks = stream.getVideoTracks()[0];

            // Stop tracks. event handler
            document.addEventListener('stopcameraTrack', () => {
                if (tracks.readyState == 'live') {
                    tracks.stop();

                    // Change the icons and button
                    if (tracks.readyState == 'ended')
                        handleMediaEnd(1, videoElement);
                }
            })

            // Resume tracks event handler
            document.addEventListener('resumecameraTrack', () => {
                // Resume the camera
                loadVideoSrc();
            })
        }
    }

    async loadVideo() {
        try {
            const media = {
                video: {
                    facingMode: 'environment',
                    width,
                    height
                }
            };

            this.modifyClass(this.permsIcons[1]).addClass('hidden');
            this.modifyClass(this.buttons[1]).removeClass('btn-danger not-allowed').addClass('btn-primary');
            this.modifyClass(document.querySelector('.video-spinner')).removeClass('d-none');
            this.modifyClass(document.querySelector('.heading')).addClass('hidden')

            const rsp = await this.mediaHandler.toggleMedia(media);

            if (rsp.error == 0) {
                // Get stream
                const { stream } = rsp;

                this.modifyClass(document.querySelector('.heading')).addClass('hidden');
                this.modifyClass(document.getElementById('warn-camera')).addClass('hidden');

                const videoElement = document.getElementById('videoElement');
                videoElement.srcObject = this.stream;
                videoElement.play();

                videoElement.addEventListener('loadedmetadata', () => {
                    document.getElementById('closeModal').click();
                });

                this.configureCameraEventListeners(stream);

                this.modifyClass(document.querySelector('.video-spinner')).addClass('d-none');
            }

        } catch {
            this.permissionQuery.showError('Camera access not granted.');
        }
    }

    /**
     * 
     * @param {HTMLElement} element 
     * @returns 
     */
    modifyClass(element) {
        this.element = element;

        return this;
    }

    /**
     * 
     * @param {String} className 
     * @param {HTMLElement} element 
     */
    removeClass(className, element = null) {
        (element == null ? this.element : element).classList.remove(...className.split(' '));

        return this;
    }

    /**
     * 
     * @param {String} className 
     * @param {HTMLElement} element 
    */
    addClass(className, element = null) {
        (element == null ? this.element : element).classList.add(...className.split(' '));

        return this;
    }
}

export default MediaNavigator;