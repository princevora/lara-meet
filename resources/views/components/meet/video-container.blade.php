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
    <x-meet.device-enumerate />
</div>