import MediaNavigator from "./media-navigator.js";

class MediaUIHandler extends MediaNavigator{

    constructor() {
        super();

        this.permsIcons = document.querySelectorAll('.forbidden-icon');
        this.buttons    = document.querySelectorAll('.btn-circle');
        this.element    = null;
    }

    /**
     * 
     * @param {number} media 
     */
    async handleGrantedMedia(media = 0) {
        // Remove class
        this.modifyClass(this.buttons[media])
            .removeClass('not-allowed btn-danger')
            .addClass('btn-primary')

        // Add classes
        this.addClass('hidden', this.permsIcons[media]);
        this.addClass('hidden', document.getElementById('warn-mic'));

        console.log(media);
        
        if(media == 0){
            console.log('Loading');
            
            this.loadSound();
            return 
        }

        else if (media == 1) {
            // Load video
            this.loadVideo();

            // Add d-none class
            this.addClass('d-none', document.querySelector('.video-spinner'))
            
            return ;
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

export default MediaUIHandler;