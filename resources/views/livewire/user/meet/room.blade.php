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
                </style>

                @slot('micSlot')
                    <button data-popover-target="popover-click" data-popover-trigger="click" type="button"
                        class="disabled:bg-gray-600 disabled:shadow-inner disabled:cursor-default cursor-pointer px-4 py-2 text-sm font-medium bg-gray-800 rounded-l-xl text-white hover:text-white hover:bg-gray-900 focus:ring-blue-500 focus:text-white">
                        <span class="material-symbols-outlined">
                            keyboard_arrow_up
                        </span>
                    </button>

                    <div data-popover id="popover-click" role="tooltip"
                        class="absolute z-10 invisible inline-block w-64 text-sm text-gray-400 transition-opacity duration-300 rounded-lg shadow-sm opacity-0 border-gray-600 bg-gray-800">
                        <div
                            class="px-3 py-2 bg-gray-100 border-b border-gray-200 rounded-t-lg dark:border-gray-600 dark:bg-gray-700">
                            <h3 class="font-semibold text-gray-900 dark:text-white">Popover click</h3>
                        </div>
                        <div class="px-3 py-2">
                            <div class="!w-full">
                                <!-- Microphone Dropdown-->
                                <div class="relative inline-block text-left w-full sm:w-auto"
                                    data-device-related='microphone'>
                                    <button disabled data-tooltip-placement="top" id="microphoneDropdownButton"
                                        data-dropdown-toggle="microphoneDropdown"
                                        class="dropdown-device flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-full shadow-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 !w-full sm:w-auto disabled:bg-gray-950 disabled:text-gray-950 disabled:border-gray-800 disabled:shadow-md disabled:opacity-70">
                                        <span class="mr-2 inline-flex gap-1">
                                            <span class="material-icons-outlined text-[18px]">mic</span>
                                            <span id="info-mic">
                                                Microphone
                                            </span>
                                        </span>
                                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 9l-7 7-7-7" />
                                        </svg>
                                    </button>


                                    <div id="microphoneDropdown"
                                        class="hidden z-10 w-72 mb-2 bg-white border border-gray-200 rounded-md shadow-xl top-full"
                                        role="menu" aria-labelledby="microphoneDropdownButton">
                                        <div id="audioinput-option-container" class="" role="none">
                                            <!-- Dynamic options will be appended here -->
                                        </div>
                                    </div>

                                </div>

                                <div id="tooltip-top" role="tooltip"
                                    class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
                                    Permission Needed
                                    <div class="tooltip-arrow" data-popper-arrow></div>
                                </div>
                            </div>
                        </div>
                        <div data-popper-arrow></div>
                    </div>
                @endslot

                @slot('cameraSlot')
                    <button type="button"
                        class="disabled:bg-gray-600 disabled:shadow-inner disabled:cursor-default cursor-pointer px-4 py-2 text-sm font-medium bg-gray-800 rounded-l-xl text-white hover:text-white hover:bg-gray-900 focus:ring-blue-500 focus:text-white">
                        <span class="material-symbols-outlined">
                            keyboard_arrow_up
                        </span>
                    </button>
                @endslot

                <button onclick="handleClick()" wire:loading.attr.disabled="true" type="button" data-type="0"
                    class="btn rounded-xl bg-gray-700 hover:bg-gray-800 text-white" id="screen-capture">

                    <!-- Microphone icon -->
                    <span class="material-icons-outlined main-icon text-gray-400">present_to_all</span>
                </button>
                <button wire:loading.attr.disabled="true" type="button" data-type="0" onclick="openModal(event, 0)"
                    class="btn rounded-xl px-4 !w-24 text-white mx-2 not-allowed" id="mic">

                    <!-- Microphone icon -->
                    <span class="material-icons-outlined main-icon text-gray-400">call_end</span>
                </button>
            </x-meet.main-media-buttons>

            <x-meet.modals.request-device />
        </div>

        <!-- Right Section -->
        <div class="d-none d-md-flex align-items-center ms-auto">
            <button class="btn btn-dark btn-circle me-2" data-bs-toggle="tooltip" title="Show participants">
                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 18" class="bi bi-people"
                    style="width: 16px; height: 16px;">
                    <path
                        d="M14 2a3.963 3.963 0 0 0-1.4.267 6.439 6.439 0 0 1-1.331 6.638A4 4 0 1 0 14 2Zm1 9h-1.264A6.957 6.957 0 0 1 15 15v2a2.97 2.97 0 0 1-.184 1H19a1 1 0 0 0 1-1v-1a5.006 5.006 0 0 0-5-5ZM6.5 9a4.5 4.5 0 1 0 0-9 4.5 4.5 0 0 0 0 9ZM8 10H5a5.006 5.006 0 0 0-5 5v2a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-2a5.006 5.006 0 0 0-5-5Z" />
                </svg>
            </button>
            <button class="btn btn-dark btn-circle" data-bs-toggle="tooltip" title="Adjust volume">
                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 18" class="bi bi-volume-up"
                    style="width: 16px; height: 16px;">
                    <path
                        d="M10.836.357a1.978 1.978 0 0 0-2.138.3L3.63 5H2a2 2 0 0 0-2 2v4a2 2 0 0 0 2 2h1.63l5.07 4.344a1.985 1.985 0 0 0 2.142.299A1.98 1.98 0 0 0 12 15.826V2.174A1.98 1.98 0 0 0 10.836.357Zm2.728 4.695a1.001 1.001 0 0 0-.29 1.385 4.887 4.887 0 0 1 0 5.126 1 1 0 0 0 1.674 1.095A6.645 6.645 0 0 0 16 9a6.65 6.65 0 0 0-1.052-3.658 1 1 0 0 0-1.384-.29Zm4.441-2.904a1 1 0 0 0-.289 1.384 9.418 9.418 0 0 1 0 11.936 1 1 0 1 0 1.673 1.096A11.387 11.387 0 0 0 20 9a11.387 11.387 0 0 0-2.284-6.548 1 1 0 0 0-1.384-.29Z" />
                </svg>
            </button>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        $('body').addClass('bg-dark')
    </script>
    <script src="{{ asset('assets/js/meet/room.js') }}" type="module"></script>
@endpush
