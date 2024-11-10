@push('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css"
        integrity="sha512-jnSuA4Ss2PkkikSOLtYs8BlYIeeIK1h99ty4YfvRPAlzr377vr3CXDb7sb7eEEBYjDtcYj+AjBH3FLv5uSJuXg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('assets/css/meet.css') }}">
@endpush

<div class="container mx-auto my-5">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <!-- Left: Meeting Card (70% of the grid) -->
        <div class="col-span-2 rounded-lg">
            <!-- Content of the meeting room goes here -->
            <div class="h-[95%] w-[91%] mt-5 rounded-md relative">

                <div class="vid-container relative rounded-lg" 
                >
                    <div class="video-spinner d-none overlay-heading d-flex justify-content-center align-items-center">
                        <div class="spinner-border text-primary spinner-border-md" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>

                    <h2 class="mx-auto hidden overlay-heading heading">The Camera Content Will Appear Here</h2>

                    <video autoplay="true" id="videoElement" playsinline style="transform: scaleX(-1)"></video>

                    <!-- Bottom center: Microphone and Camera buttons -->
                    <div class="media-btns mb-3" wire:loading.class="fixed inset-0 bg-gray-500 opacity-50 pointer-events-none z-50">
                        <button wire:loading.attr.disabled="true" type="button" data-type="0"
                            onclick="openModal(event, 0)" class="btn btn-circle text-white mx-2 not-allowed"
                            id="mic">

                            <!-- Microphone icon -->
                            <span class="material-icons main-icon text-gray-400">mic</span>

                            <!-- Warning badge -->
                            <span id="warn-mic"
                                class="position-absolute top-0 translate-middle badge rounded-pill bg-warning p-1">
                                <span class="material-icons text-sm">priority_high</span>
                            </span>
                            <span class="forbidden material-icons hidden">
                                mic_off
                            </span>
                        </button>
                        <button wire:loading.attr.disabled='true' type="button" data-type="1"
                            onclick="openModal(event, 1)" id="webcame"
                            class="btn btn-circle btn-danger mx-2 not-allowed relative">

                            <!-- Microphone icon -->
                            <span class="material-icons main-icon text-gray-400">videocam</span>

                            <!-- Warning badge -->
                            <span id="warn-camera"
                                class="position-absolute top-0 translate-middle badge rounded-pill bg-warning p-1">
                                <span class="material-icons text-sm">priority_high</span>
                            </span>
                            <span class="forbidden material-icons hidden">
                                videocam_off
                            </span>
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
</div>

@push('scripts')
    <script>
        const microphoneUrl = "{{ asset('assets/images/microphone-access.svg') }}";
        const videoUrl = "{{ asset('assets/images/camera-access.svg') }}";
    </script>
    <script src="{{ asset('assets/js/meet.js') }}"></script>
@endpush
