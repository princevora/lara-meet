import MediaHandler from "./media-handler.js";

class MediaNavigator {
    constructor () {
        this.mediaHandler = new MediaHandler();   
    }

    loadSound() {
        console.log('Loadded Audio');
    }

    loadVideo() {
        console.log('Loadded video');
        
    }
}

export default MediaNavigator;