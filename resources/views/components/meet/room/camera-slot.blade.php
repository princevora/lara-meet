<button wire:ignore.self data-popover-target="popover-click-camera" data-popover-trigger="click" type="button"
    class="disabled:bg-gray-600 disabled:shadow-inner disabled:cursor-default cursor-pointer px-4 py-2 text-sm font-medium bg-gray-800 rounded-l-xl text-white hover:text-white hover:bg-gray-900 focus:ring-blue-500 focus:text-white">
    <span class="material-symbols-outlined">
        keyboard_arrow_up
    </span>
</button>
<div wire:ignore.self class="ignore-class">
    <div data-popover id="popover-click-camera" role="tooltip"
        class="absolute z-10 invisible inline-block w-auto text-sm text-gray-400 transition-opacity duration-300 rounded-lg shadow-sm opacity-0 border-gray-600 bg-gray-800">
        <div class="px-3 py-2 bg-gray-100 border-b rounded-t-lg dark:border-gray-600 bg-transparent">
            <h3 class="font-semibold text-gray-900 dark:text-white">Change Microphone And
                Speaker
                Device
            </h3>
        </div>
        <div class="px-3 py-2">
            <!-- Microphone Dropdown-->
            <div class="relative flex gap-2 text-left w-full" data-device-related='camera'>
                <button disabled id="cameraDropDownButton" data-dropdown-toggle="cameraDropdown"
                    class="!h-auto dropdown-device flex px-4 py-2 text-sm font-medium text-gray-400 bg-gray-900 border border-dark rounded-full shadow-md hover:bg-gray-950 focus:outline-none ring-2 ring-indigo-500 focus:ring-indigo-900 !w-full sm:!w-full disabled:bg-gray-950 disabled:border-gray-800 disabled:shadow-md disabled:opacity-70">
                    <span class="mr-2 inline-flex gap-1">
                        <span class="material-icons-outlined text-[18px]">videocam</span>
                        <span id="info-speaker">
                            Camera
                        </span>
                    </span>
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <!-- Speakers Options (positioned to open on top) -->
                <div id="cameraDropdown"
                    class="hidden z-10 w-72 mb-2 bg-dark border font-medium border-dark rounded-md shadow-xl top-full"
                    role="menu" aria-labelledby="cameraDropDownButton">
                    <div class="py-1" id="videoinput-option-container" role="none">
                    </div>
                </div>
            </div>
        </div>
        <div data-popper-arrow></div>
    </div>
</div>
