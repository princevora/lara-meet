<div class="">
    <!-- drawer component -->
    <div id="room-members"
        class="fixed top-0 right-0 z-40 h-screen p-4 overflow-y-auto transition-transform translate-x-full bg-gray-800 w-80"
        tabindex="-1" aria-labelledby="drawer-right-label">
        <h5 id="drawer-right-label"
            class="inline-flex items-center mb-4 text-base font-semibold text-gray-400">
            <svg class="w-4 h-4 me-2.5" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path
                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
            </svg>
            Right drawer
        </h5>
        <button type="button" data-drawer-hide="room-members" aria-controls="room-members"
            class="text-gray-400 hover:bg-gray-600 hover:text-white rounded-lg text-sm w-8 h-8 absolute top-2.5 end-2.5 inline-flex items-center justify-center">
            <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
            </svg>
            <span class="sr-only">Close menu</span>
        </button>
        <div class="py-4 overflow-y-auto">
            <ul class="space-y-2 font-medium">
                @foreach ($members as $member)
                    <li>
                        <button class="w-full flex items-center p-2 text-white rounded-lg group hover:bg-gray-700">
                            <span
                                class="flex items-center justify-center w-8 h-8 rounded-xl bg-gray-700 text-white text-sm leading-none group-hover:bg-gray-400 transition">
                                {{ Str::upper($member->user->name[0]) }}
                            </span>
                            <span class="ms-3">
                                @if ($member->user->id === auth()->user()->id)
                                    You
                                @else
                                    {{ Str::limit($member->user->name, 15) }}
                                @endif
                            </span>
                        </button>
                    </li>
                @endforeach

                <div class="flex justify-center">
                    {{ $members->links('paginator') }}
                </div>
            </ul>
        </div>
    </div>

</div>
