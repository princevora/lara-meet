import MediaUIHandler from "./media-ui-handler.js";

class MediaHandler
{

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
}

export default MediaHandler;