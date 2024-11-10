import MediaHandler from "../media/media-handler.js";
import MediaUIHandler from "../media/media-ui-handler.js";

class PermissionQuery {

    constructor() {
        this.error = 0;
        this.microphonePermissions = null;
        this.cameraPermissions = null;
        this.mediaHandler = new MediaHandler();
        this.mediaUIHandler = new MediaUIHandler();
    }

    async getPermission() {
        return new Promise(async (resolve, reject) => {
            try {
                [this.microphonePermissions, this.cameraPermissions] = await Promise.all([
                    navigator.permissions.query({ name: 'microphone' }),
                    navigator.permissions.query({ name: 'camera' })
                ]);

                // Return this
                resolve(this);

            } catch (err) {
                console.log(err);
                this.error = 'Could not check permissions. Please try again.';

                reject(this.error);
            }
        });
    }

    registerHandlers() {
        if (this.microphonePermissions) {
            this.microphonePermissions.onchange = (e) => this.mediaHandler.handleChange(e, 0);
        }
        if (this.cameraPermissions) {
            this.cameraPermissions.onchange = (e) => this.mediaHandler.handleChange(e, 1);
        }
        return this;
    }

    configureGrantedHandlers() {
        if (this.microphonePermissions && this.microphonePermissions.state === 'granted') {
            this.mediaUIHandler.handleGrantedMedia(0);
        }
        if (this.cameraPermissions && this.cameraPermissions.state === 'granted') {
            this.mediaUIHandler.handleGrantedMedia(1);
        }
        return this;
        // else $('.heading').removeClass('hidden');
    }

    getCurrentPermissions() {
        return {
            microphone: this.microphonePermissions,
            camera: this.cameraPermissions,
            error: this.error
        };
    }

    /**
     * 
     * @param {String} message 
     */
    showError(message) {
        const el = document.getElementById('error-context');
        el.textContent = message;
        el.classList.remove('hidden');
    }
}

export default PermissionQuery;