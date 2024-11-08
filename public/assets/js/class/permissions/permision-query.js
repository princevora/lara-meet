import MediaHandler from "../media/media-handler.js";
import MediaUIHandler from "../media/media-ui-handler.js";

class PermissionQuery {

    constructor() {
        this.error                  = 0;
        this.microphonePermissions  = null;
        this.cameraPermissions      = null;
        this.mediaHandler           = new MediaHandler();
        this.mediaUIHandler         = new MediaUIHandler();
    }

    async getPermission() {
        try {

            [this.microphonePermissions, this.cameraPermissions] = await Promise.all([
                navigator.permissions.query({ name: 'microphone' }),
                navigator.permissions.query({ name: 'camera' })
            ]);


            // Register The handlers
            this.registerHandlers();

        } catch (err) {
            console.log(err);

            this.error = 'Could not check permissions. Please try again.';
        }

        return this;
    }

    registerHandlers() {
        this.microphonePermissions.onchange = (e) => this.mediaHandler.handleChange(e, 0);
        this.cameraPermissions.onchange     = (e) => this.mediaHandler.handleChange(e, 1);
    }

    configureGrantedHandlers() {
        if (this.microphonePermissions.state === 'granted') this.mediaUIHandler.handleGrantedMedia(0);
        if (this.cameraPermissions.state     === 'granted') this.mediaUIHandler.handleGrantedMedia(1);
        // else $('.heading').removeClass('hidden');
    }
}

export default PermissionQuery;