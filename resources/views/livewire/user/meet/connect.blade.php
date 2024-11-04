@push('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css"
        integrity="sha512-jnSuA4Ss2PkkikSOLtYs8BlYIeeIK1h99ty4YfvRPAlzr377vr3CXDb7sb7eEEBYjDtcYj+AjBH3FLv5uSJuXg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        /* Custom Styles */
        body {
            background-color: #f5f7fa;
        }

        .meeting-card {
            position: relative;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            height: 400px;
        }

        .btn-circle {
            border-radius: 50%;
            width: 50px;
            height: 50px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 20px;
        }

        .bottom-buttons {
            position: absolute;
            bottom: 10px;
            left: 50%;
            transform: translateX(-50%);
        }

        .connect-panel {
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .not-allowed {
            background-color: rgba(255, 0, 0, 0.6);
            /* Red background for not allowed state */
            position: relative;
            /* Position relative for child elements */
            width: 56px;
            /* Adjust width according to your icon size */
            height: 56px;
            /* Adjust height according to your icon size */
        }

        .media-btns button {
            width: 56px !important;
            height: 56px !important;
        }

        .main-icon {
            color: white;
            /* Color for the main icon */
            font-size: 24px;
            /* Size of the main icon */
            position: relative;
            /* Ensure positioning for the main icon */
            z-index: 1;
            /* Keep main icon above forbidden icon */
        }

        .forbidden-icon {
            color: white;
            /* Color for the forbidden backslash */
            font-size: 36px;
            /* Size of the forbidden backslash */
            position: absolute;
            /* Position absolutely to overlap */
            top: 50%;
            /* Center vertically */
            left: 50%;
            /* Center horizontally */
            transform: translate(-50%, -50%);
            /* Adjust to center correctly */
            z-index: 2;
            /* Ensure the forbidden icon is on top */
            font-family: monospace;
            /* Use a monospace font for better backslash appearance */
        }
    </style>
@endpush

<div class="container mx-auto my-5">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <!-- Left: Meeting Card (70% of the grid) -->
        <div class="col-span-2 bg-white rounded-lg shadow-lg p-6">
            <h3 class="text-center text-xl font-semibold mb-4">Meeting Room</h3>

            <!-- Content of the meeting room goes here -->
            <div class="h-75 w-full bg-gray-100 rounded-md relative">
                <style>
                    #videoElement {
                        width: 781.328px;
                        height: 391.984px;
                        background-color: #777;
                        border-radius: inherit;
                    }

                    .vid-container {
                        width: 781.328px;
                        height: 100%;
                        background-color: #777;
                        border-radius: inherit;
                    }

                    .overlay-heading {
                        z-index: 1;
                        position: absolute;
                        top: 50%;
                        left: 50%;
                        transform: translate(-50%, -50%);
                        color: white;
                        font-size: 1.5rem;
                        text-align: center;
                    }

                    /* Styles for the progress bar */
                    .progress-container {
                        position: absolute;
                        /* Positioning the progress bar absolutely */
                        bottom: 0;
                        /* Align to the bottom */
                        left: 0;
                        /* Align to the left */
                        width: 100%;
                        background-color: #e0e0e0;
                        /* Removed border-radius to make it square */
                        height: 10px;
                        /* Make the progress bar thinner */
                    }

                    .progress-bar {
                        height: 100%;
                        /* Set to 100% of the container */
                        width: 0;
                        /* Initial width, can be adjusted dynamically */
                        background-color: #4caf50;
                        /* Color of the progress bar */
                        transition: width 0.5s ease;
                        /* Smooth transition for width changes */
                    }
                </style>

                <div class="vid-container relative rounded-lg">
                    <div class="video-spinner d-none overlay-heading d-flex justify-content-center align-items-center">
                        <div class="spinner-border text-primary spinner-border-md" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>

                    <h2 class="hidden overlay-heading heading">The Camera Content Will Appear Here</h2>
                    <video autoplay="true" id="videoElement" playsinline style="transform: scaleX(-1)"></video>
                    <!-- Bottom center: Microphone and Camera buttons -->
                    <div class="media-btns flex justify-center mt-4 relative">
                        <button wire:loading.attr.disabled='true' type="button" data-type="0"
                            onclick="openModal(event, 0)" class="btn btn-circle btn-danger mx-2 not-allowed"
                            id="mic">
                            <i class="fas fa-microphone-alt main-icon"></i> <!-- Microphone icon -->
                            <span id="warn-mic"
                                class=" position-absolute top-0 translate-middle badge rounded-pill bg-warning">
                                !
                                <span class="visually-hidden">unread messages</span>
                            </span>
                            <span class="forbidden-icon"> \ </span> <!-- Forbidden backslash -->
                        </button>
                        <button wire:loading.attr.disabled='true' type="button" data-type="1"
                            onclick="openModal(event, 1)" id="webcame"
                            class="btn btn-circle btn-danger mx-2 not-allowed relative">
                            <i class="fas fa-video main-icon"></i> <!-- Camera icon -->
                            <span id="warn-camera"
                                class=" position-absolute top-0 translate-middle badge rounded-pill bg-warning">
                                !
                                <span class="visually-hidden">unread messages</span>
                            </span>
                            <span class="forbidden-icon"> \ </span> <!-- Forbidden backslash -->
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right: Connect Panel (30% of the grid) -->
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h5 class="text-lg font-semibold mb-3">Request Connect</h5>
            <button type="button"
                class="w-full bg-green-500 text-white font-semibold py-2 rounded hover:bg-green-600 transition duration-200">Connect</button>
        </div>
    </div>

    <!-- Modal -->
    <div id="modal"
        class="modal fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center transition-opacity duration-300 opacity-0 pointer-events-none"
        style="display: none;">
        <div
            class="bg-white rounded-lg shadow-lg p-6 w-11/12 md:w-1/3 transform scale-95 transition-transform duration-300">
            <div class="flex justify-end">
                <button id="closeModal" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times fa-lg"></i>
                </button>
            </div>
            <img id="modal-image" draggable="false" alt="Microphone" class="mx-auto mb-4">
            <h2 class="text-xl font-semibold text-center mb-2" id="modal-heading"></h2>
            <p class="text-gray-600 text-center mb-4" id="modal-desc">

            </p>
            <div class="text-center">
                <small id="error-context" class="hidden text-danger">
                    Error occued
                </small>
            </div>
            <div class="text-center">
                <button id="mediaButton"
                    class="bg-green-500 text-white font-semibold py-2 px-4 rounded hover:bg-green-600">
                </button>
            </div>
        </div>
    </div>

</div>

@push('scripts')
    <script>
        const microphoneUrl = 'https://i.pinimg.com/originals/b7/60/b3/b760b325414acc57d15a6133cbf59986.jpg';
        const videoUrl =
            'https://png.pngtree.com/png-vector/20230213/ourmid/pngtree-desktop-webcam-illustration-png-image_6598897.png';

        const preloadImage = (url) => {
            $('<link>', {
                rel: 'preload',
                href: url
            }).appendTo('head');
        };
        preloadImage(microphoneUrl);
        preloadImage(videoUrl);

        let micAllowed = 0;
        let cameraAllowed = 0;

        // Check for browser support of cookieStore
        if ('cookieStore' in window) {
            cookieStore.get('mic-allowed').then((value) => micAllowed = value?.value || 0);
            cookieStore.get('camera-allowed').then((value) => cameraAllowed = value?.value || 0);

            cookieStore.addEventListener('change', (event) => {
                event.changed.forEach(cookie => {
                    if (cookie.name === 'mic-allowed') {
                        micAllowed = cookie.value;
                    }
                    if (cookie.name === 'camera-allowed') {
                        cameraAllowed = cookie.value;
                    }
                });
            });
        }

        const toggleMedia = async (media) => {
            try {
                const stream = await navigator.mediaDevices.getUserMedia(media);
                return stream;
            } catch (error) {
                console.error('Error accessing media devices:', error);
                showError('Unable to access media devices.');
            }
        };

        const handleGrantedMedia = async (media = 0) => {
            const permsIcons = document.querySelectorAll('.forbidden-icon');
            const buttons = document.querySelectorAll('.btn-circle');
            const expectedMedia = media == 0 ? 'mic' : 'camera';
            
            if(media == 0) {
                $(buttons[0]).removeClass('not-allowed btn-danger').addClass('btn-primary');
                $(permsIcons[0]).addClass('hidden');
                $('#warn-mic').addClass('hidden');
                await loadSound();
            }

            if(media == 1) {
                $('.video-spinner').removeClass('d-none');
                $('.heading').addClass('hidden');
                $('#warn-camera').addClass('hidden');

                await loadVideoSrc();

                $('.video-spinner').addClass('d-none');
            }

            buttons[media].onclick = () => toggleMediaUI(media);
            await cookieStore.set(`${expectedMedia}-allowed`, 1);
        }

        const getPermissions = async () => {
            try {
                const micPerms = await navigator.permissions.query({
                    name: 'microphone'
                });
                micPerms.onchange = (e) => handleMediaChange(e, 0);

                const cameraPerms = await navigator.permissions.query({
                    name: 'camera'
                });
                cameraPerms.onchange = (e) => handleMediaChange(e, 1);

                return [micPerms.state, cameraPerms.state];
            } catch (error) {
                console.error("Error getting permissions:", error);
                showError("Could not check permissions. Please try again.");
            }
        };

        /**
         * @param {int} media
         * 
         * the toggleMediaUI expects media parameter to be int
         * 0 = microphone
         * 1 = camera
         * 
         * every dynamic toggling work will be done with this 
         */
        const toggleMediaUI = async (media = 0) => {
            const expectedMedia = media == 0 ? 'mic' : 'camera';

            // get current cookie
            const currentValue = await cookieStore.get(`${expectedMedia}-allowed`);

            // Change to string
            const newValue = (Number(currentValue?.value) ^ 1).toString();

            // Set cookie
            await cookieStore.set('mic-allowed', newValue);

            // Get microphone and camera permissions
            const [micState, camState] = await getPermissions();

            const btns = document.querySelectorAll('.btn-circle');

            if (Number(newValue) === 1 && micState === 'granted') {
                $('.forbidden-icon').eq(0).hide();
                btns[0].onclick = () => toggleMediaUI(); // Ensure toggleMediaUI is set for the granted state
            } else {
                if (micState !== 'granted') {
                    btns[0].onclick = (event) => openModal(event, 0);
                }
                $('.btn-circle').eq(0).addClass('not-allowed btn-danger');
                $('.forbidden-icon').eq(0).show();
            }
        };

        const handleMediaChange = (e, media = 0) => {
            if (e.currentTarget.state) {
                const state = e.currentTarget.state;
                const btns = document.querySelectorAll('.btn-circle');
                const expectedMedia = media == 0 ? 'mic' : 'camera';

                if (state === 'granted') {

                    handleGrantedMedia(media)

                    // Toggle media
                    btns[media].onclick = () => toggleMediaUI(media);

                } else if (state === 'denied') {
                    $(`#warn-${expectedMedia}`).removeClass('hidden');

                    // Add onclick on appropriate button
                    btns[media].onclick = (event) => openModal(event, media);
                } else if (state === 'prompt') {
                    $(`#warn-${expectedMedia}`).removeClass('hidden');
                    btns[media].onclick = (event) => openModal(event, media);
                }
            }

            if ($('#modal').css('display') !== 'none' && $('#modal').css('opacity') > 0) {
                $('#modal').hide();
            }
        }

        getPermissions().then(([micState, cameraState]) => {
            if (micState === 'granted') handleGrantedMedia(0);
            if (cameraState === 'granted') handleGrantedMedia(1);
            else $('.heading').removeClass('hidden');
        });

        const updateMicrophoneUI = () => {
            const permsIcons = document.querySelectorAll('.forbidden-icon');
            const buttons = document.querySelectorAll('.btn-circle');

            // Update the button and icon for microphone access
            $(buttons[0]).removeClass('not-allowed btn-danger').addClass('btn-primary');
            $(permsIcons[0]).addClass('hidden');

            // Hide any warning for microphone access
            $('#warn-mic').addClass('hidden');
        };

        const requestMicrophone = async () => {
            const [micState] = await getPermissions();
            if (micState !== 'granted' && micState === 'prompt') {
                try {
                    await loadSound();
                    updateMicrophoneUI(); // Call the newly defined function
                    await cookieStore.set('mic-allowed', 1);
                    $('#closeModal').click();
                } catch {
                    showError('Microphone access not granted.');
                }
            } else if (micState === 'denied') {
                showError('You have denied microphone permission. Please enable it in site settings.');
            }
        };


        const requestCamera = async () => {
            const [, cameraState] = await getPermissions();
            if (cameraState !== 'granted' && cameraState === 'prompt') {
                return handleGrantedMedia(1);
            } else if (cameraState === 'denied') {
                showError('You have denied webcam permission. Please enable it in site settings.');
            }
        };

        const loadVideoSrc = async (width = 900, height = 450) => {
            try {
                const permsIcons = document.querySelectorAll('.forbidden-icon');
                const buttons = document.querySelectorAll('.btn-circle');

                $(permsIcons[1]).addClass('hidden');
                $(buttons[1]).removeClass('btn-danger not-allowed').addClass('btn-primary');

                const media = {
                    video: {
                        facingMode: 'environment',
                        width,
                        height
                    }
                };
                const stream = await toggleMedia(media);

                const videoElement = document.getElementById('videoElement');
                videoElement.srcObject = stream;
                videoElement.play();

                stream.getVideoTracks()[0].onended = () => handleMediaEnd(1, videoElement);
                $('#videoElement').on('loadedmetadata', () => {
                    $('.heading').addClass('hidden');
                    $('#closeModal').click();
                });
            } catch {
                showError('Camera access not granted.');
            }
        };

        // videoElement
        const handleMediaEnd = (media = 0, videoElement = null) => {
            const expectedMedia = media == 0 ? 'mic' : 'camera';

            if (media == 1) {
                videoElement.srcObject = null;
                
                $('.heading').removeClass('hidden').text('The webcam has been disabled');
            }
            
            cookieStore.set(`${expectedMedia}-allowed`, 0);
            $('.forbidden-icon').eq(media).removeClass('hidden');
            $('.btn-circle').eq(media).addClass('not-allowed btn-danger').removeClass('btn-primary');
         }

         const loadSound = async () => {
            try {
                const media = {
                    audio: true
                };
                const stream = await toggleMedia(media);
                stream.getAudioTracks()[0].onended = () => handleMediaEnd(0);
            } catch (error) {
                console.error('Microphone access error:', error);
                showError('Microphone access not granted.');
            }
        };


        const showError = (message) => {
            $('#error-context').removeClass('hidden').text(message);
        };

        const openModal = (event, type) => {
            const modalData = {
                0: {
                    heading: 'Let people hear what you say.',
                    desc: 'To talk, please enable your microphone for audio input.',
                    src: microphoneUrl,
                    buttonText: 'Enable Microphone',
                    onClick: requestMicrophone
                },
                1: {
                    heading: 'Talk live with people using webcam.',
                    desc: 'Enable webcam to talk live.',
                    src: videoUrl,
                    buttonText: 'Enable Webcam',
                    onClick: requestCamera
                }
            };

            const data = modalData[type];
            $('#modal-heading').text(data.heading);
            $('#modal-desc').text(data.desc);
            $('#modal-image').attr('src', data.src);
            $('#mediaButton').text(data.buttonText).off('click').on('click', data.onClick);
            $('#modal').css('display', 'flex').removeClass('opacity-0 pointer-events-none');
            setTimeout(() => $('#modal > div').removeClass('scale-95'), 10);
        };

        $('#closeModal').on('click', () => {
            $('#modal').addClass('opacity-0 pointer-events-none');
            $('#modal > div').addClass('scale-95');
            $('#error-context').text('');
            setTimeout(() => $('#modal').hide(), 200);
        });

        $(window).on('click', (e) => {
            $('#error-context').text('');
            if ($(e.target).is('#modal')) $('#closeModal').click();
        });
    </script>

    <!-- Bootstrap and Icons Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"
        integrity="sha512-7Pi/otdlbbCR+LnW+F7PwFcSDJOuUJB3OxtEHbg4vSMvzvJjde4Po1v4BR9Gdc9aXNUNFVUY+SK51wWT8WF0Gg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@endpush
