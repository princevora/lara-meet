@push('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css"
        integrity="sha512-jnSuA4Ss2PkkikSOLtYs8BlYIeeIK1h99ty4YfvRPAlzr377vr3CXDb7sb7eEEBYjDtcYj+AjBH3FLv5uSJuXg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('assets/css/meet.css') }}">
@endpush

<div class="container mx-auto my-3">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <!-- Left: Meeting Card (70% of the grid) -->
        <div wire:loading.class='opacity-50 pointer-events-none' class="col-span-2 rounded-lg">
            <!-- Content of the meeting room goes here -->
            <div class="h-[81%] w-[91%] mt-5 rounded-md relative">

                <div class="vid-container relative rounded-lg">
                    <div class="video-spinner d-none overlay-heading d-flex justify-content-center align-items-center">
                        <div class="spinner-border text-primary spinner-border-md" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>

                    <h2 class="mx-auto hidden overlay-heading heading">The Camera Content Will Appear Here</h2>

                    <video autoplay="true" id="videoElement" playsinline style="transform: scaleX(-1)"></video>

                    <!-- Bottom center: Microphone and Camera buttons -->
                    <div class="media-btns mb-3"
                        wire:loading.class="fixed inset-0 bg-gray-500 opacity-50 pointer-events-none z-50">
                        <button wire:loading.attr.disabled="true" type="button" data-type="0"
                            onclick="openModal(event, 0)" class="btn btn-circle text-white mx-2 not-allowed"
                            id="mic">

                            <!-- Microphone icon -->
                            <span class="material-icons-outlined main-icon text-gray-400">mic</span>

                            <!-- Warning badge -->
                            <span id="warn-mic"
                                class="position-absolute top-0 translate-middle badge rounded-pill bg-warning p-1">
                                <span class="material-icons-outlined text-xs/3">priority_high</span>
                            </span>
                            <span class="forbidden material-icons-outlined hidden">
                                mic_off
                            </span>
                        </button>
                        <button wire:loading.attr.disabled='true' type="button" data-type="1"
                            onclick="openModal(event, 1)" id="webcame"
                            class="btn btn-circle btn-danger mx-2 not-allowed relative">

                            <!-- Microphone icon -->
                            <span class="material-icons-outlined main-icon text-gray-400">videocam</span>

                            <!-- Warning badge -->
                            <span id="warn-camera"
                                class="position-absolute top-0 translate-middle badge rounded-pill bg-warning p-1">
                                <span class="material-icons-outlined text-xs/3">priority_high</span>
                            </span>
                            <span class="forbidden material-icons-outlined hidden">
                                videocam_off
                            </span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="container mx-auto p-4">
                <div class="flex flex-col sm:flex-row items-center space-y-4 sm:space-x-4 sm:space-y-0 select-none">
                    <!-- Microphone Dropdown-->
                    <div class="relative inline-block text-left w-full sm:w-auto">
                        <button id="microphoneDropdownButton" data-dropdown-toggle="microphoneDropdown"
                            class="flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-full shadow-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 w-full sm:w-auto">
                            <span class="mr-2 inline-flex gap-1">
                                <span class="material-icons-outlined text-[18px]">mic</span>
                                <span id="info-mic">
                                    Microphone
                                </span>
                            </span>
                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <!-- Microphone Options  -->
                        <div id="microphoneDropdown"
                            class="hidden z-10 w-56 mb-2 bg-white border border-gray-200 rounded-md shadow-xl top-full"
                            role="menu" aria-labelledby="microphoneDropdownButton">
                            <div class="py-1" role="none">
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                    role="menuitem">Built-in Microphone</a>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                    role="menuitem">External Microphone</a>
                            </div>
                        </div>
                    </div>

                    <!-- Speakers Dropdown -->
                    <div class="relative inline-block text-left w-full sm:w-auto">
                        <button id="speakersDropdownButton" data-dropdown-toggle="speakersDropdown"
                            class="flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-full shadow-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 w-full sm:w-auto">
                            <span class="mr-2 inline-flex gap-1">
                                <span class="material-icons-outlined text-[18px]">volume_up</span>
                                <span id="info-speaker">
                                    Speakers / Headphones
                                </span>
                            </span>
                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <!-- Speakers Options (positioned to open on top) -->
                        <div id="speakersDropdown"
                            class="hidden z-10 w-56 mb-2 bg-white border border-gray-200 rounded-md shadow-lg top-full"
                            role="menu" aria-labelledby="speakersDropdownButton">
                            <div class="py-1" role="none">
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                    role="menuitem">Built-in Speakers</a>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                    role="menuitem">External Speakers</a>
                            </div>
                        </div>
                    </div>

                    <!-- Camera Dropdown -->
                    <div class="relative inline-block text-left w-full sm:w-auto">
                        <button id="cameraDropDownButton" data-dropdown-toggle="cameraDropdown"
                            class="flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-full shadow-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 w-full sm:w-auto">
                            <span class="mr-2 inline-flex gap-1">
                                <span class="material-icons-outlined text-[18px]">videocam</span>
                                <span id="info-speaker">
                                    Camera
                                </span>
                            </span>
                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <!-- Speakers Options (positioned to open on top) -->
                        <div id="cameraDropdown"
                            class="hidden z-10 w-56 mb-2 bg-white border border-gray-200 rounded-md shadow-lg top-full"
                            role="menu" aria-labelledby="cameraDropDownButton">
                            <div class="py-1" role="none">
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                    role="menuitem">Built-in Speakers</a>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
                                    role="menuitem">External Speakers</a>
                            </div>
                        </div>
                    </div>
                </div>
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
</div>

@push('scripts')
    <script>
        const microphoneUrl = "{{ asset('assets/images/microphone-access.svg') }}";
        const videoUrl = "{{ asset('assets/images/camera-access.svg') }}";
    </script>
    <script src="{{ asset('assets/js/main.js') }}" type="module"></script>
@endpush
