import MediaHandler from "../media/media-handler.js";
import MediaUIHandler from "../media/media-ui-handler.js";
import stylesContent from "./style-content.js";

class PermissionElement extends HTMLElement {
    static validType = ['mic', 'camera'];
    static ui = {
        mic: {
            id: 'mic',
            icon: 'fas fa-microphone-alt main-icon',
        },
        camera: {
            id: 'webcame',
            icon: 'fas fa-video main-icon',
        }
    }

    constructor() {
        super();

        this.callables = {
            mic: this.configureMic,
            camera: this.configureCamera
        };

        this.mediaType = null;
        this.permissionType = null;

        this.attachShadow({ mode: 'open' });
        this.mediaHandler = new MediaHandler();
    }

    get validType() {
        return PermissionElement.validType;
    }

    get ui() {
        return PermissionElement.ui;
    }

    addStyles() {
        const style = document.createElement('style');

        style.textContent = stylesContent;

        const fa = document.querySelector('link[href*="font-awesome"]');
        const tailwind = document.querySelector('script[src*="tailwindcss"]');
        const bootstrap = document.querySelector('link[href*="bootstrap.min.css"]');

        // Add font awesome for icons in shadow dom.
        if (fa) {
            this.shadowRoot.appendChild(fa.cloneNode());
        }

        if (tailwind) {
            this.shadowRoot.appendChild(tailwind.cloneNode());
        }

        if (bootstrap) {
            this.shadowRoot.appendChild(bootstrap.cloneNode());
        }

        this.shadowRoot.appendChild(style);
    }

    connectedCallback() {

        this.addStyles();

        this.permissionType = this.getAttribute('permission-type') || 'mic';
        this.mediaType      = this.permissionType == 'mic' ? 0 : 1;

        if (this.validType.includes(this.permissionType)) {
            // Call the configurable functions.
            this.callables[this.permissionType].call(this);
        }
    }

    configureMic() {
        return this.buildElement();
    }

    buildElement() {
        if(this.mediaType !== null){
            const uiData = this.ui[this.permissionType];
            const button = document.createElement('button');
            const i = document.createElement('i');
            const firstSpan = document.createElement('span');
            const childSpan = document.createElement('span');
            const secondSpan = document.createElement('span');
            
            button.onclick = (e) => new MediaUIHandler().openModal(e, this.mediaType);
            button.setAttribute('data-type', this.mediaType);
            button.setAttribute('type', 'button');
            button.setAttribute('class', 'btn btn-danger btn-circle mx-2 not-allowed relative');
            button.setAttribute('id', uiData.id);
            button.setAttribute('wire:loading.attr.disabled', true);
            button.setAttribute('wire:loading.attr.disabled', true);
    
            // Icon setup
            i.setAttribute('class', uiData.icon);
    
            // First span setup
            firstSpan.setAttribute('id', `warn-${this.permissionType}`);
            firstSpan.setAttribute('class', 'position-absolute top-0 translate-middle badge rounded-pill bg-warning');
            firstSpan.textContent = '!';
    
            secondSpan.setAttribute('class', 'forbidden-icon');
            secondSpan.textContent = '\\';
    
            childSpan.setAttribute('class', 'visually-hidden');
            childSpan.textContent = 'unread messages';
    
            button.appendChild(i);
            button.appendChild(firstSpan);
            firstSpan.appendChild(childSpan);
            button.appendChild(secondSpan);
            
            return this.shadowRoot.appendChild(button);
        }
    }

    configureCamera() {
        return this.buildElement();
    }
}

customElements.define('permission-element', PermissionElement);