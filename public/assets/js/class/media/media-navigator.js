import MediaHandler from "./media-handler.js";

class MediaNavigator {
    
    constructor() {
        this.mediaHandler = new MediaHandler();
        this.stream       = null;
    }

    async loadSound() {
        try {
            const media = {
                audio: true
            };

            const rsp = await this.mediaHandler.toggleMedia(media);

            if (rsp.error == 0) {
                ({stream: this.stream} = rsp);

                // Handle Audio End
                const tracks = stream.getAudioTracks()[0];

                tracks.onended = () => this.mediaHandler.handleMediaEnd(0);

            }

            else {
                throw rsp.error;
            }

        } catch (error) {
            this.showError('Microphone access not granted.');
        }

        return this;

    }

    configureSoundEventListeners() {
        if(this.stream){
            const tracks = this.stream.getAudioTracks()[0];

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

    loadVideo() {
        console.log('Loadded video');
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

export default MediaNavigator;