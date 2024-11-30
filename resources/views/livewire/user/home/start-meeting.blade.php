<!-- Create Meeting Section -->
<div class="text-center">
    <button id="dropdownInformationButton" data-dropdown-toggle="dropdownInformation"
        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
        type="button">Create Meeting <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true"
            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="m1 1 4 4 4-4" />
        </svg>
    </button>

    <!-- Dropdown menu -->
    <div id="dropdownInformation"
        class="z-10 hidden divide-y rounded-lg shadow w-44 bg-gray-900 divide-gray-600">
        <div class="px-4 py-3 text-sm text-white">
            <div>Lara - Meet</div>
            <div class="font-medium text-wrap">Create Meeting</div>
        </div>
        <ul class="py-2 bg-gray-900 text-sm text-gray-200"
            aria-labelledby="dropdownInformationButton">
            <li class="bg-gray-900">
                <a href="#"
                    class="px-4 py-2 gap-2 bg-gray-900 hover:bg-gray-900 hover:text-white flex">
                    <span class="material-symbols-outlined">
                        add
                    </span>
                    <span>
                        Start Meeting
                    </span>
                </a>
            </li>
        </ul>
    </div>
</div>