<!-- Modal -->
<div id="modal"
    class="modal fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center transition-opacity duration-300 opacity-0 pointer-events-none"
    style="display: none;">
    <div class="bg-white rounded-lg shadow-lg p-6 w-11/12 md:w-1/3 transform scale-95 transition-transform duration-300">
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
            <button id="mediaButton" class="bg-green-500 text-white font-semibold py-2 px-4 rounded hover:bg-green-600">
            </button>
        </div>
    </div>
</div>
