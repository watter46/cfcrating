<div class="w-full">
    @if ($paginator->hasPages())
        <nav class="flex justify-between" role="navigation"
            aria-label="Pagination Navigation">
            <span>
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <button
                        class="flex items-center justify-center w-10 h-10 leading-tight text-gray-400 bg-gray-700 border-gray-600 rounded-full cursor-default hover:bg-gray-600 hover:text-gray-300"
                        rel="prev">
                        <svg class="w-4 h-4" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round"
                                stroke-linejoin="round" stroke-width="2"
                                d="M5 1 1 5l4 4" />
                        </svg>
                    </button>
                @else
                    <button
                        class="flex items-center justify-center w-10 h-10 leading-tight text-gray-400 bg-gray-700 border-gray-600 rounded-full hover:bg-gray-600 hover:text-gray-300"
                        wire:click="previousPage" wire:loading.attr="disabled"
                        rel="prev">
                        <svg class="w-4 h-4" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round"
                                stroke-linejoin="round" stroke-width="2"
                                d="M5 1 1 5l4 4" />
                        </svg>
                    </button>
                @endif
            </span>

            <span>
                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <button
                        class="flex items-center justify-center w-10 h-10 leading-tight text-gray-400 bg-gray-700 border-gray-600 rounded-full hover:bg-gray-600 hover:text-gray-300"
                        wire:click="nextPage" wire:loading.attr="disabled"
                        rel="next">
                        <svg class="w-3 h-3" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round"
                                stroke-linejoin="round" stroke-width="2"
                                d="m1 9 4-4-4-4" />
                        </svg>
                    </button>
                @else
                    <button
                        class="flex items-center justify-center w-10 h-10 leading-tight text-gray-400 bg-gray-700 border-gray-600 rounded-full hover:bg-gray-600 hover:text-gray-300"
                        rel="next">
                        <svg class="w-3 h-3" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round"
                                stroke-linejoin="round" stroke-width="2"
                                d="m1 9 4-4-4-4" />
                        </svg>
                    </button>
                @endif
            </span>
        </nav>
    @endif
</div>