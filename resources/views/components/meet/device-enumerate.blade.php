<div class="container mx-auto p-4">
    <div class="flex flex-col sm:flex-row items-center space-y-4 sm:space-x-4 sm:space-y-0 select-none">
        <!-- Microphone Dropdown-->
        <div class="relative inline-block text-left w-full sm:w-auto" data-device-related='microphone'>
            <button disabled data-tooltip-placement="top" id="microphoneDropdownButton"
                data-dropdown-toggle="microphoneDropdown"
                class="flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-full shadow-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 w-full sm:w-auto disabled:bg-gray-950 disabled:text-gray-950 disabled:border-gray-800 disabled:shadow-md disabled:opacity-70">
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
                class="hidden z-10 w-72 mb-2 bg-white border border-gray-200 rounded-md shadow-xl top-full"
                role="menu" aria-labelledby="microphoneDropdownButton">
                <div id="audioinput-option-container" class="py-1" role="none">
                </div>
            </div>
        </div>
        
        <div id="tooltip-top" role="tooltip"
            class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip dark:bg-gray-700">
            Permission Needed
            <div class="tooltip-arrow" data-popper-arrow></div>
        </div>

        <!-- Speakers Dropdown -->
        <div class="relative inline-block text-left w-full sm:w-auto" data-device-related='microphone'>
            <button disabled id="speakersDropdownButton" data-dropdown-toggle="speakersDropdown"
                class="flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-full shadow-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 w-full sm:w-auto disabled:bg-gray-950 disabled:text-gray-950 disabled:border-gray-800 disabled:shadow-md disabled:opacity-70">
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
                <div id="audiooutput-option-container" class="py-1" role="none">
                </div>
            </div>
        </div>

        <!-- Camera Dropdown -->
        <div class="relative inline-block text-left w-full sm:w-auto" data-device-related='camera'>
            <button disabled id="cameraDropDownButton" data-dropdown-toggle="cameraDropdown"
                class="flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-full shadow-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 w-full sm:w-auto disabled:bg-gray-950 disabled:text-gray-950 disabled:border-gray-800 disabled:shadow-md disabled:opacity-70">
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
                <div class="py-1" id="videoinput-option-container" role="none">
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    {{-- Show tooltip when a button is disabled --}}
    <script>
        $(document).ready(function (){
            if('Tooltip' in window) {
                $('div[data-device-related]').on('mouseover', (e) => {
                    // console.log('HEE');
                    
                    if (e.target?.closest('button')?.disabled) {
                        const tooltipElement = document.getElementById('tooltip-top');
                        const buttonElement = e.target.closest('button');
        
                        const tooltip = new Tooltip(tooltipElement, buttonElement);
                        tooltip.show();
                    }
                })
            }
        })
    </script>
@endpush
