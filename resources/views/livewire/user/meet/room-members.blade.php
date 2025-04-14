<div x-data="roomMembers" x-init="init()">
    <!-- drawer component -->
    <div id="room-members"
        class="shadow-2xl border-l border-l-gray-700 fixed top-0 right-0 z-50 h-screen p-4 overflow-y-auto transition-transform bg-neutral-800 w-80 translate-x-full rounded-l-[1rem]"
        :class="{ 'transform-none': !open, 'translate-x-full': open }" tabindex="-1" aria-labelledby="drawer-right-label"
        :aria-hidden="!open" aria-modal="true" role="dialog">
        <h5 id="drawer-right-label" class="inline-flex items-center mb-4 text-base font-semibold text-gray-400">
            <svg class="w-4 h-4 me-2.5" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path
                    d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z" />
            </svg>
            Right drawer
        </h5>

        <button type="button" data-drawer-hide="room-members" aria-controls="room-members"
            class="text-gray-400 hover:bg-gray-600 hover:text-white rounded-lg text-sm w-8 h-8 absolute top-2.5 end-2.5 inline-flex items-center justify-center"
            @click="open = false">
            <svg class="w-3 h-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
            </svg>
            <span class="sr-only">Close menu</span>
        </button>


        <div x-show="isLoading" role="status" class="animate-pulse">
            <div class="flex items-center justify-center mt-4">
                <svg class="w-8 h-8 text-gray-200 dark:text-gray-700 me-4" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm0 5a3 3 0 1 1 0 6 3 3 0 0 1 0-6Zm0 13a8.949 8.949 0 0 1-4.951-1.488A3.987 3.987 0 0 1 9 13h2a3.987 3.987 0 0 1 3.951 3.512A8.949 8.949 0 0 1 10 18Z" />
                </svg>
                <div class="w-20 h-2.5 bg-gray-200 rounded-full dark:bg-gray-700 me-3"></div>
                <div class="w-24 h-2 bg-gray-200 rounded-full dark:bg-gray-700"></div>
            </div>
            <span class="sr-only">Loading...</span>
        </div>


        <div class="py-4 overflow-y-auto">
            <ul class="space-y-2 font-medium" id="member-list">
                <template x-for="user in users" :key="user.id">
                    <li>
                        <button class="w-full flex items-center p-2 text-white rounded-lg group hover:bg-gray-700">
                            <span
                                class="flex items-center justify-center w-8 h-8 rounded-xl bg-gray-700 text-white text-sm leading-none group-hover:bg-gray-400 transition"
                                x-text="user.initial">
                            </span>
                            <span class="ms-3" x-text="user.id === currentUserId ? 'You' : user.name"></span>
                        </button>
                    </li>
                </template>
            </ul>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('alpine:init', () => {
                const title = "Room Update!";

                Alpine.data('roomMembers', () => ({
                    open: true, // assume drawer is opened by parent logic
                    currentUserId: @json(auth()->user()->id),
                    users: [],
                    room_id: null,
                    room: null,
                    isLoading: true,
                    init() {
                        if (window._echoInitDone) return;
                        window._echoInitDone = true;
                        window.roomMembersInstance = this;
                       
                        this.room_id = @json($meeting->id);
                        this.room = @json($room);
                        const roomId = @json($room); 

                        Echo.join(`user-joined.${roomId}`)
                            .listen('.UserJoined', user => {
                                const event = new CustomEvent('event:peer-joined', {
                                    detail: {
                                        user
                                    }
                                });

                                document.dispatchEvent(event);
                            })
                            .here(users => {
                                this.users = users.map(u => this.formatUser(u));
                                
                                this.isLoading = false;
                            })
                            .joining(user => {
                                if (!this.users.find(u => u.id === user.id)) {
                                    this.users.push(this.formatUser(user));
                                }

                                const message = `User ${user.name} has been Joined 👋`;
                                const type = 'show';

                                toast(title, message);
                            })
                            .leaving(user => {
                                this.users = this.users.filter(u => u.id !== user.id);

                                const event = new CustomEvent('event:peer-left', {
                                    detail: {
                                        user
                                    }
                                });

                                document.dispatchEvent(event);

                                const message = `User ${user.name} has been left from the meeting 👋`;
                                const type = 'warning';

                                toast(title, message);
                            });
                    },
                    formatUser(user) {
                        return {
                            id: user.id,
                            name: user.name.length > 15 ? user.name.slice(0, 15) + '…' : user.name,
                            initial: user.name.charAt(0).toUpperCase(),
                        };
                    }
                }));
            });

            window.addEventListener('beforeunload', () => {
                const formData = new FormData();
                formData.append('_token', '{{ csrf_token() }}');
                formData.append('room', '{{ request()->code }}')
                formData.append('user_id', '{{ auth()->user()->id }}')

                navigator.sendBeacon("{{ route('user-left') }}", formData);
            });


            function toast(name, message, type = "show") {
                const backgroundColor = {
                    success: '#166534', // Tailwind green-800
                    error: '#7f1d1d', // Tailwind red-800
                    info: '#1e3a8a', // Tailwind blue-800
                    warning: '#92400e', // Tailwind amber-800
                    show: '#1f2937' // Tailwind gray-800 (fallback)
                };

                iziToast[type]({
                    title: name,
                    message,
                    position: 'topCenter',
                    timeout: 4000,
                    theme: 'dark',
                    backgroundColor: backgroundColor[type],
                    titleColor: '#4ade80',
                    messageColor: '#d1d5db',
                    iconUrl: null,
                    layout: 2,
                    drag: true,
                    close: false,
                    progressBar: false
                });
            }
        </script>
    @endpush
</div>
