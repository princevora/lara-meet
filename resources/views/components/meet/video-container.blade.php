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

            <x-meet.main-media-buttons />
            <x-meet.modals.request-device />

        </div>
    </div>

    <x-meet.device-enumerate />
</div>
