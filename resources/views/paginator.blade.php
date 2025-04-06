@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="mt-4">
        <ul class="inline-flex -space-x-px text-sm">

            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li>
                    <span class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-gray-800 border border-gray-700 rounded-s-lg cursor-not-allowed">
                        Previous
                    </span>
                </li>
            @else
                <li>
                    <a wire:click.prevent="previousPage" href="#" class="flex items-center justify-center px-3 h-8 leading-tight text-gray-400 bg-gray-800 border border-gray-700 rounded-s-lg hover:bg-gray-700 hover:text-white">
                        Previous
                    </a>
                </li>
            @endif

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li>
                    <a wire:click.prevent="nextPage" href="#" class="flex items-center justify-center px-3 h-8 leading-tight text-gray-400 bg-gray-800 border border-gray-700 rounded-e-lg hover:bg-gray-700 hover:text-white">
                        Next
                    </a>
                </li>
            @else
                <li>
                    <span class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-gray-800 border border-gray-700 rounded-e-lg cursor-not-allowed">
                        Next
                    </span>
                </li>
            @endif
        </ul>
    </nav>
@endif
