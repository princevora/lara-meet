import MediaUIHandler from "./media-ui-handler.js";

class MediaHandler {

    constructor() {
        this.stream = null;
    }

    /**
     *  0 = Microphone
     *  1 = camera - Webcame
     * 
     * @param { Event } e 
     * @param { number } media 
     */
    handleChange(e, media = 0) {
        console.log(e);
    }

    async toggleMedia(media) {
        let error = 0;

        try {
            this.stream = await navigator.mediaDevices.getUserMedia(media);
        } catch (error) {
            showError('Unable to access media devices.');
        }

        return {
            stream: this.stream,
            error
        };
    }

    handleMediaEnd (media) {
        
    }
}

export default MediaHandler;