import PermissionQuery from "./permision-query.js";

class PermissionElement extends HTMLElement{
    static validType = ['mic', 'camera'];

    /**
     * @static  {object} callables
     */
    static callables = {
        mic: 'loadAudio',
        camera: 'loadVideo'
    };

    constructor() {
        super();

        this.attachShadow({ mode: 'open' });
    }

    get validType() {
        return PermissionElement.validType;
    }

    handleClick() {
        
    }

    connectedCallback() {

        const permissionType = this.getAttribute('permission-type') || 'mic';

        this.onclick = this.handleClick;

        this.shadowRoot.innerHTML = `
            <style>
                .permission-content {
                    padding: 5px;
                    background-color: #f4f4f4;
                    border: 1px solid #ccc;
                    border-radius: 5px;
                    font-size: 14px;
                }
            </style>
            <div class="permission-content">
                <strong>Permission Type:</strong> ${permissionType}
            </div>
        `;
    }
}

customElements.define('permission-query', PermissionElement);