import PermissionQuery from "./permision-query.js";

class PermissionElement extends HTMLElement {
    static validType = ['mic', 'camera'];

    constructor() {
        super();

        this.callables = {
            mic: this.configureMic,
            camera: this.configureCamera
        };

        this.attachShadow({ mode: 'open' });
    }

    get validType() {
        return PermissionElement.validType;
    }

    addStyles() {
        const style = document.createElement('style');

        style.textContent = `
            .btn-circle {
                border-radius: 50%;
                width: 50px;
                height: 50px;
                display: flex;
                justify-content: center;
                align-items: center;
                font-size: 20px;
            }
            
            .not-allowed {
                background-color: rgba(255, 0, 0, 0.6);
                position: relative;
                width: 56px;
                height: 56px;
            }

            button {
                width: 56px !important;
                height: 56px !important;
            }

            .main-icon {
                color: white;
                font-size: 24px;
                position: relative;
                z-index: 1;
            }

            .forbidden-icon {
                color: white;
                font-size: 36px;
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                z-index: 2;
                font-family: monospace;
            }
        `;

        const fa        = document.querySelector('link[href*="font-awesome"]');
        const tailwind  = document.querySelector('script[src*="tailwindcss"]');
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

        const permissionType = this.getAttribute('permission-type') || 'mic';

        if (this.validType.includes(permissionType)) {
            // Call the configurable functions.
            this.callables[permissionType].call(this);
        }
    }

    configureMic() {
        const button = document.createElement('button');
        const i = document.createElement('i');
        const firstSpan = document.createElement('span');
        const childSpan = document.createElement('span');
        const secondSpan = document.createElement('span');

        button.setAttribute('data-typ', '0');
        button.setAttribute('type', 'button');
        button.setAttribute('class', 'btn btn-danger btn-circle not-allowed');
        button.setAttribute('id', 'mic');
        button.setAttribute('wire:loading.attr.disabled', true);
        button.setAttribute('wire:loading.attr.disabled', true);

        // Icon setup
        i.setAttribute('class', 'fas fa-microphone-alt main-icon');

        // First span setup
        firstSpan.setAttribute('id', 'warn-mic');
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

        this.shadowRoot.appendChild(button);
    }

    configureCamera() {
        console.log('Configued cam');

    }
}

customElements.define('permission-query', PermissionElement);