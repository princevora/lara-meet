<div class="container mx-auto my-3">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <!-- Left: Meeting Card (70% of the grid) -->
        <x-meet.video-container />

        <!-- Right: Connect Button -->
        <div class="flex items-center justify-center">
            <a href="{{ route('meet.room', ['code' => $code]) }}" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg shadow">
                Connect to Meeting
            </a>
        </div>
    </div>
</div>