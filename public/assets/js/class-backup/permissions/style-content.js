const stylesContent = `
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

export default stylesContent;