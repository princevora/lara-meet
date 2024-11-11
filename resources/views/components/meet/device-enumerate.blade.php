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
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
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
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
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
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
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
