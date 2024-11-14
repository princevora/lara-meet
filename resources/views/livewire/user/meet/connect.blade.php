@push('style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css"
        integrity="sha512-jnSuA4Ss2PkkikSOLtYs8BlYIeeIK1h99ty4YfvRPAlzr377vr3CXDb7sb7eEEBYjDtcYj+AjBH3FLv5uSJuXg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('assets/css/meet.css') }}">
@endpush

<div class="container mx-auto my-3">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <!-- Left: Meeting Card (70% of the grid) -->
        <x-meet.video-container />

        <!-- Modal -->
        <div id="modal"
            class="modal fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center transition-opacity duration-300 opacity-0 pointer-events-none"
            style="display: none;">
            <div
                class="bg-white rounded-lg shadow-lg p-6 w-11/12 md:w-1/3 transform scale-95 transition-transform duration-300">
                <div class="flex justify-end">
                    <button id="closeModal" class="text-gray-500 hover:text-gray-700">
                        <i class="fas fa-times fa-lg"></i>
                    </button>
                </div>
                <img id="modal-image" draggable="false" alt="Microphone" class="mx-auto mb-4">
                <h2 class="text-xl font-semibold text-center mb-2" id="modal-heading"></h2>
                <p class="text-gray-600 text-center mb-4" id="modal-desc">

                </p>
                <div class="text-center">
                    <small id="error-context" class="hidden text-danger">
                        Error occued
                    </small>
                </div>
                <div class="text-center">
                    <button id="mediaButton"
                        class="bg-green-500 text-white font-semibold py-2 px-4 rounded hover:bg-green-600">
                    </button>
                </div>
            </div>
        </div>

    </div>
</div>

@push('scripts')
    <script>
        const microphoneUrl = "{{ asset('assets/images/microphone-access.svg') }}";
        const videoUrl = "{{ asset('assets/images/camera-access.svg') }}";
    </script>
    
    <script src="{{ asset('assets/js/meet/main.js') }}" type="module"></script>
@endpush
