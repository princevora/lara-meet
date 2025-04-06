<div id="drawer-navigation"
    class="fixed top-0 left-0 z-40 w-64 h-screen p-4 overflow-y-auto transition-transform -translate-x-full bg-gray-800"
    tabindex="-1" aria-labelledby="drawer-navigation-label">
    <h5 id="drawer-navigation-label" class="text-base font-semibold text-gray-400 uppercase">Members Of this Meeting</h5>
    <button type="button" data-drawer-hide="drawer-navigation" aria-controls="drawer-navigation"
        class="text-gray-400 bg-transparent hover:bg-gray-600 hover:text-white rounded-lg text-sm p-1.5 absolute top-2.5 end-2.5 inline-flex items-center">
        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
            xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd"
                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                clip-rule="evenodd"></path>
        </svg>
        <span class="sr-only">Close menu</span>
    </button>
    <div class="py-4 overflow-y-auto">
        <ul class="space-y-2 font-medium">
            @foreach ($members as $member)
                <li>
                    <a href="#" class="flex items-center p-2 text-white rounded-lg group hover:bg-gray-700">
                        <span class="flex items-center justify-center w-8 h-8 rounded-xl bg-gray-700 text-white text-sm leading-none group-hover:bg-gray-400 transition">
                            p
                        </span>
                        <span class="ms-3">
                            {{ Str::limit($member->user->name, 15) }}
                        </span>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
</div>
