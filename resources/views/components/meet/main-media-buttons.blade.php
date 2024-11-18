<div>
    <!-- Bottom center: Microphone and Camera buttons -->
    <div class="{{ $class }}" wire:loading.class="fixed inset-0 bg-gray-500 opacity-50 pointer-events-none">
        <div @class(['inline-flex' => $addMicGroupButton])>
            @if ($addMicGroupButton)
                {!! $micSlot ?? '' !!}
            @endif
            <button @class([
                'btn btn-circle text-white not-allowed',
                '!rounded-r-xl !rounded-l-none' => $addMicGroupButton,
            ]) wire:loading.attr.disabled="true" type="button" data-type="0"
                onclick="openModal(event, 0)" id="mic">
                <!-- Microphone icon -->
                <span class="material-icons-outlined main-icon text-gray-400">mic</span>

                <!-- Warning badge -->
                <span id="warn-mic" class="position-absolute top-0 translate-middle badge rounded-pill bg-warning p-1">
                    <span class="material-icons-outlined text-xs/3">priority_high</span>
                </span>
                <span class="forbidden material-icons-outlined hidden">
                    mic_off
                </span>
            </button>
        </div>
        <div @class(['inline-flex' => $addMicGroupButton, 'mx-2'])>
            @if ($addCameraGroupButton)
                {!! $cameraSlot ?? '' !!}
            @endif
            <button wire:loading.attr.disabled='true' type="button" data-type="1" onclick="openModal(event, 1)"
                id="webcame" @class([
                    'btn btn-circle btn-danger not-allowed relative',
                    '!rounded-r-xl !rounded-l-none' => $addMicGroupButton,
                ])>

                <!-- Microphone icon -->
                <span class="material-icons-outlined main-icon text-gray-400">videocam</span>

                <!-- Warning badge -->
                <span id="warn-camera"
                    class="position-absolute top-0 translate-middle badge rounded-pill bg-warning p-1">
                    <span class="material-icons-outlined text-xs/3">priority_high</span>
                </span>
                <span class="forbidden material-icons-outlined hidden">
                    videocam_off
                </span>
            </button>
        </div>

        {{ $slot }}
    </div>
</div>
