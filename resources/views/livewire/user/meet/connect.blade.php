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
            position: relative;
            width: 56px;
            height: 56px;
        }

        .media-btns button {
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
                        <permission-query permission-type="mic"></permission-query>
                    </div>
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
                                class=" position-absolute top-0  translate-middle badge rounded-pill bg-warning">
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
    </script>
@endpush
