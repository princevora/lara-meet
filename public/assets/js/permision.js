class PermissionElement extends HTMLElement {
    constructor() {
        super();

        this.attachShadow({ mode: 'open' });
    }

    connectedCallback() {
        const permissionType = this.getAttribute('permission-type') || 'mic';

        this.shadowRoot.innerHTML = `
            <style>
            /* Styles scoped to the shadow DOM */
            .permission-content {
            padding: 10px;
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