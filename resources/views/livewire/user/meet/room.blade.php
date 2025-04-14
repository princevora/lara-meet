<div id="room" class="">
    @if (!$isLoaded)
        <x-meet.room-loader :isLoaded="$isLoaded" />
    @endif
    @push('style')
        <style>
            .bg-blue:hover {
                background-color: #7ea6e7;
            }

            .bg-blue:active {
                background-color: #7ea6e7;
            }


            .bg-blue {
                background-color: #a8c7fa;
            }

            .bg-blue span {
                color: #062e6f !important;
            }

            .text-ellipsis {
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }
        </style>

        <script src="https://cdn.jsdelivr.net/npm/izitoast@1.4.0/dist/js/iziToast.min.js"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/izitoast@1.4.0/dist/css/iziToast.min.css">
    @endpush

    <div wire:ignore class="p-4">
    </div>

    {{-- <video id="videoElement"></video> --}}

    <div class="d-flex justify-content-center">
        <div class="h-[14%] fixed-bottom mb-4 p-3 rounded-2xl d-flex justify-content-between align-items-center"
            style="width: 95%;">
            <!-- Left Section -->
            <div class="d-none d-md-flex align-items-center gap-2 text-secondary me-auto">
                <span class="material-symbols-outlined">
                    schedule
                </span>
                <span class="text-sm font-medium" id="date-time"></span>
            </div>

            <!-- Center Section -->
            <div class="d-flex align-items-center justify-content-center">
                {{-- Make buttons rectangular --}}
                <style>
                    .btn-circle {
                        border-radius: 20%;
                    }
                </style>

                <x-meet.main-media-buttons addMicGroupButton addCameraGroupButton class="media-btns">
                    <!-- Popover Element -->
                    <div id="popover-click" data-popover role="tooltip"
                        class="absolute overflow-hidden z-10 invisible w-72 transition-opacity duration-300 p-0 rounded-md shadow-lg opacity-0 bg-[#1e1f20]">
                        <a href="javascript:void(0)"
                            class="block text-gray-300 py-[.825rem] px-4 hover:bg-gray-700 hover:text-white hover:rounded-none transition-all duration-200 w-full">
                            <span class="font-medium flex gap-3">
                                <span class="material-symbols-outlined">select_window</span>
                                <span>Present Something Else</span>
                            </span>
                        </a>
                        <a href="javascript:void(0)" onclick="stopPresentation()"
                            class="block text-gray-300 py-[.825rem] px-4 hover:bg-gray-700 hover:text-white hover:rounded-none transition-all duration-200 w-full">
                            <span class="font-medium flex gap-3">
                                <span class="material-symbols-outlined">cancel_presentation</span>
                                <span>Stop Presenting</span>
                            </span>
                        </a>
                        <div data-popper-arrow class="bg-[#1e1f20]"></div>
                    </div>

                    @slot('micSlot')
                        <x-meet.room.mic-slot/>
                    @endslot

                    <div id="tooltip-top" role="tooltip"
                        class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                        Permission Needed
                        <div class="tooltip-arrow" data-popper-arrow></div>
                    </div>

                    @slot('cameraSlot')
                        <x-meet.room.camera-slot />
                    @endslot

                    <button wire:ignore onclick="handleClick()" wire:loading.attr.disabled="true" type="button" data-type="0"
                        class="btn rounded-xl bg-gray-700 hover:bg-gray-800 text-white" id="screen-capture">

                        <!-- Microphone icon -->
                        <span class="material-icons-outlined main-icon text-gray-400">present_to_all</span>
                    </button>
                    <button wire:ignore wire:loading.attr.disabled="true" type="button" data-type="0"
                        onclick="openModal(event, 0)" class="btn rounded-xl px-4 !w-24 text-white mx-2 not-allowed"
                        id="mic">

                        <!-- Microphone icon -->
                        <span class="material-icons-outlined main-icon text-gray-400">call_end</span>
                    </button>
                </x-meet.main-media-buttons>

                <x-meet.modals.request-device />
            </div>

            <!-- Right Section -->
            <div class="d-none d-md-flex align-items-center ms-auto">
                <button data-drawer-backdrop="true" class="btn btn-dark btn-circle me-2"
                    data-drawer-target="room-members" data-drawer-show="room-members" data-drawer-placement="right"
                    aria-controls="room-members" data-bs-toggle="tooltip" title="Show participants">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 18"
                        class="bi bi-people" style="width: 16px; height: 16px;">
                        <path
                            d="M14 2a3.963 3.963 0 0 0-1.4.267 6.439 6.439 0 0 1-1.331 6.638A4 4 0 1 0 14 2Zm1 9h-1.264A6.957 6.957 0 0 1 15 15v2a2.97 2.97 0 0 1-.184 1H19a1 1 0 0 0 1-1v-1a5.006 5.006 0 0 0-5-5ZM6.5 9a4.5 4.5 0 1 0 0-9 4.5 4.5 0 0 0 0 9ZM8 10H5a5.006 5.006 0 0 0-5 5v2a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-2a5.006 5.006 0 0 0-5-5Z" />
                    </svg>
                </button>
                <button wire:click="dispatchFetchMessages" data-drawer-backdrop="true"
                    class="btn btn-dark btn-circle me-2" data-drawer-target="room-chat" data-drawer-show="room-chat"
                    data-drawer-placement="right" aria-controls="room-chat" data-bs-toggle="tooltip"
                    title="Messages">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M8.625 12a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 0 1-2.555-.337A5.972 5.972 0 0 1 5.41 20.97a5.969 5.969 0 0 1-.474-.065 4.48 4.48 0 0 0 .978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25Z" />
                    </svg>
                </button>

                <!-- drawer components -->
                <livewire:user.meet.room-members />
                <livewire:user.meet.room-chat :$room :$user />
            </div>
        </div>
    </div>

    @push('scripts')
        @if (!$isLoaded)
            <script src="{{ asset('assets/js/meet/room.js') }}" type="module"></script>
        @endif
        @script
            <script>
                Livewire.hook('component.init', ({
                    component
                }) => {
                    const roomContainer = document.getElementById('room');
                    const roomContainerID = roomContainer.getAttribute('wire:id');

                    // Initialize only once if the wire room container id 
                    // and the initialized component id is the same

                    if (roomContainerID === component.id) {
                        return initializeRoom();
                    }
                })

                document.addEventListener('sendMicrophoneBlog', function(data) {
                    const audio = new Audio(data.detail.objectUrl);
                    audio.play().catch(e => {
                        console.log(e);
                    });
                    console.log(data.detail.objectUrl);
                });
                $('body').addClass('bg-dark')

                const observer = new MutationObserver(() => {
                    const backdrops = document.querySelectorAll('*[drawer-backdrop]');
                    backdrops.forEach(backdrop => {
                        backdrop.classList.add('!bg-neutral-300', 'opacity-5');
                    });
                });

                observer.observe(document.body, {
                    childList: true,
                    subtree: true,
                });


                $(document).ready(function() {

                    if ('Tooltip' in window) {
                        $('div[data-device-related]').on('mouseover', (e) => {

                            if (e.target?.closest('button.dropdown-device')?.disabled) {
                                const tooltipElement = document.getElementById('tooltip-top');
                                const buttonElement = e.target.closest('button');

                                const tooltip = new Tooltip(tooltipElement, buttonElement);
                                tooltip.show();
                            }
                        })
                    }
                })
            </script>
        @endscript
    @endpush

</div>
