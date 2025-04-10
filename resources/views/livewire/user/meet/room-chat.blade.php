<div wire:poll.60s>
    @push('style')
        <style>
            @tailwind utilities;

            @layer utilities {
                @keyframes progress {

                    0%,
                    100% {
                        transform: translateX(0%);
                        width: 20%;
                    }

                    50% {
                        transform: translateX(200%);
                        width: 40%;
                    }
                }

                .animate-progress {
                    animation: progress 1.5s ease-in-out infinite;
                }

                /* Custom dark scrollbar */
                .custom-scrollbar::-webkit-scrollbar {
                    width: 8px;
                }

                .custom-scrollbar::-webkit-scrollbar-track {
                    background: #2a2a2a;
                }

                .custom-scrollbar::-webkit-scrollbar-thumb {
                    background-color: #555;
                    border-radius: 8px;
                }

                .custom-scrollbar::-webkit-scrollbar-thumb:hover {
                    background: #777;
                }

                /* Firefox */
                .custom-scrollbar {
                    scrollbar-width: thin;
                    scrollbar-color: #555 #2a2a2a;
                }
            }
        </style>
    @endpush

    <div wire:ignore.self id="room-chat"
        class="border-l border-l-gray-700 fixed top-0 right-0 z-40 h-screen p-4 overflow-x-hidden overflow-y-auto transition-transform translate-x-full bg-neutral-800 w-[30rem] rounded-l-[2.3rem] flex flex-col shadow-2xl">

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
        <div x-data x-init="$nextTick(() => { $el.scrollTop = $el.scrollHeight })" x-ref="chatContainer" class="h-[90%] overflow-y-auto custom-scrollbar">
            @if (!isset($chats))
                {!! $this->initalizePlaceholder() !!}
            @elseif(isset($chats))
                @if ($chats->count() > 0)
                    @foreach ($chats as $message)
                        <div class="flex-1 overflow-y-auto space-y-2 pr-1 mt-2">
                            @php
                                // Checks if the previous message and the current message iteration
                                // was sent by the same sender as previous one..
                                $wasPreviousMessageFromSameSender =
                                    @$chats[$loop->index - 1]->sender_id !== $message->sender->id;
                            @endphp
                            @if ($message->sender_id !== $user->id)
                                <div class="flex gap-2">
                                    @if ($wasPreviousMessageFromSameSender)
                                        <p title="{{ $message->sender->name }}"
                                            class="w-8 h-8 bg-gray-600 text-white rounded-full flex items-center justify-center font-semibold">
                                            {{ $message->sender->name[0] }}
                                        </p>
                                    @endif

                                    <div
                                        class="text-md text-white bg-neutral-700 px-4 py-2 rounded-2xl w-fit max-w-[80%]">
                                        {{ Crypt::decryptString($message->message) }}
                                        <br>
                                        <span class="text-[12px]">
                                            {{ $message->created_at->diffForHumans() }}
                                        </span>
                                    </div>
                                </div>
                            @else
                                <div class="flex items-end gap-2">
                                    <!-- Message bubble -->
                                    <div
                                        class="text-md text-white bg-blue-600 px-4 py-2 rounded-2xl w-fit max-w-[80%] self-end ml-auto {{ !$wasPreviousMessageFromSameSender ? 'mr-4' : '' }}">
                                        {{ Crypt::decryptString($message->message) }}
                                    </div>

                                    @if ($wasPreviousMessageFromSameSender)
                                        <!-- Circular Avatar -->
                                        <div
                                            class="w-9 h-9 bg-gray-700 text-white rounded-full flex items-center justify-center text-xs font-bold shadow-md">
                                            You
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>
                    @endforeach
                    <span x-effect="$refs.chatContainer.scrollTop = $refs.chatContainer.scrollHeight">
                    </span>
                @else
                    <p class="text-center text-white">
                        There Is Nothing To See.
                    </p>
                @endif
            @endif
        </div>

        <!-- Chat Input -->
        <div class="border-t border-neutral-800 pt-3 relative">
            <!-- Loading Bar -->
            <div wire:loading wire:target="sendMessage" class="absolute top-0 left-0 w-full">
                <div class="h-0.5 w-full bg-gray-700 rounded-full overflow-hidden">
                    <div class="h-0.5 bg-blue-500 animate-progress rounded-full w-[20%]"></div>
                </div>
            </div>

            <form wire:submit.prevent="sendMessage" class="relative z-10">
                <input wire:model="message" type="text"
                    class="p-3 block w-full border border-neutral-700 rounded-full text-sm focus:outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-500 focus:ring-opacity-50 bg-neutral-800 text-neutral-300 placeholder-neutral-500"
                    placeholder="Chat.." />
                <div class="absolute top-1/2 right-2 -translate-y-1/2">
                    <button type="submit"
                        class="h-10 w-10 inline-flex justify-center items-center text-sm font-semibold rounded-full text-neutral-400 hover:text-white bg-neutral-700">
                        <svg wire:loading.remove wire:target='sendMessage' xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5" />
                        </svg>
                        <div wire:loading wire:target="sendMessage"
                            class="animate-spin inline-block size-4 border-3 border-current border-t-transparent text-blue-600 rounded-full dark:text-blue-500"
                            role="status" aria-label="loading">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </button>
                </div>
            </form>
        </div>

    </div>
    @push('scripts')
        @script
            <script>
                document.addEventListener('alpine:init', () => {});
            </script>
        @endscript
    @endpush
</div>
