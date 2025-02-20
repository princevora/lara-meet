<div class="min-h-screen flex items-center justify-center bg-gray-900">
    <div class="w-full max-w-md p-8 bg-gray-800 rounded-lg shadow-2xl">
        <form wire:submit.prevent='save'>
            <div class="text-center mb-8">
                <h2 class="text-2xl font-bold text-white">Welcome to the Meeting</h2>
                <p class="text-gray-400 mt-2">Please enter your name to continue</p>
            </div>

            <div class="mb-6">
                <label class="block text-gray-300 text-sm font-semibold mb-2">Your Name</label>
                <input 
                    wire:model='name' 
                    type="text" 
                    class="w-full px-4 py-3 rounded-lg bg-gray-700 text-white border border-gray-600 focus:border-blue-500 focus:ring-2 focus:ring-blue-500 focus:outline-none transition duration-200"
                    placeholder="John Doe"
                >
                @error('name')
                    <p class="mt-2 text-sm text-red-500">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <button 
                type="submit" 
                wire:loading.attr="disabled"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-4 rounded-lg transition duration-200 flex items-center justify-center gap-2 disabled:opacity-50"
            >
                <span>Continue to Meeting</span>
                <div wire:loading wire:target='save' role="status">
                    <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </div>
            </button>
        </form>
    </div>
</div>
