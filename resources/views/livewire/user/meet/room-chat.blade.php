<div>
    <div id="room-chat"
        class="border-l border-l-gray-700 fixed top-0 right-0 z-40 h-screen p-4 overflow-hidden transition-transform bg-neutral-800 w-[30rem] rounded-l-[2.3rem] flex flex-col">

        <!-- Header -->
        <h5 id="drawer-right-label" class="inline-flex items-center mb-4 text-base font-semibold text-neutral-400">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="mx-2 size-6">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M8.625 12a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 0 1-2.555-.337A5.972 5.972 0 0 1 5.41 20.97a5.969 5.969 0 0 1-.474-.065 4.48 4.48 0 0 0 .978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25Z" />
            </svg>
            Chat With Members
        </h5>
        <button type="button" data-drawer-hide="room-chat" aria-controls="room-chat"
            class="text-gray-400 hover:bg-gray-600 hover:text-white rounded-lg text-sm w-8 h-8 absolute top-2.5 end-2.5 inline-flex items-center justify-center">
            <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
            </svg>
            <span class="sr-only">Close menu</span>
        </button>

        <!-- Chat messages scrollable area -->
        <div class="flex-1 overflow-y-auto space-y-2 pr-1">
            <div class="text-sm text-white bg-neutral-700 px-4 py-2 rounded-2xl w-fit max-w-[80%]">Hello!</div>
            <div class="text-sm text-white bg-blue-600 px-4 py-2 rounded-2xl w-fit max-w-[80%] self-end ml-auto">Hi
                there!</div>
        </div>

        <!-- Chat Input -->
        <div class="pt-3 border-t border-neutral-800">
            <form class="relative">
                <input type="text"
                    class="p-3 block w-full border border-neutral-700 rounded-full text-sm focus:outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-500 focus:ring-opacity-50 bg-neutral-800 text-neutral-300 placeholder-neutral-500"
                    placeholder="Chat.." />
                <div class="absolute top-1/2 right-2 -translate-y-1/2">
                    <button type="button"
                        class="h-10 w-10 inline-flex justify-center items-center text-sm font-semibold rounded-full text-neutral-400 hover:text-white bg-neutral-700">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5" />
                        </svg>
                    </button>
                </div>
            </form>
        </div>
    </div>
    @push('scripts')
        @script
            <script>
                document.addEventListener('alpine:init', () => {
                });
            </script>
        @endscript
    @endpush
</div>
