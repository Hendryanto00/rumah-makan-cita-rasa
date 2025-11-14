@if ($paginator->hasPages())
    <nav aria-label="Page navigation" class="flex items-center justify-center">
        <ul class="flex items-center space-x-1 sm:space-x-2">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li>
                    <span class="px-3 py-2 text-sm font-medium text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed flex items-center gap-1">
                        <i class="fas fa-chevron-left text-xs"></i>
                        <span class="hidden sm:inline">Sebelumnya</span>
                    </span>
                </li>
            @else
                <li>
                    <a href="{{ $paginator->previousPageUrl() }}" 
                       rel="prev" 
                       aria-label="@lang('pagination.previous')"
                       class="px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-orange-50 hover:border-orange-300 hover:text-orange-600 transition-colors flex items-center gap-1">
                        <i class="fas fa-chevron-left text-xs"></i>
                        <span class="hidden sm:inline">Sebelumnya</span>
                    </a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li>
                        <span class="px-3 py-2 text-sm font-medium text-gray-500">{{ $element }}</span>
                    </li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li>
                                <span class="px-3 py-2 text-sm font-medium text-white bg-orange-500 rounded-lg cursor-default">
                                    {{ $page }}
                                </span>
                            </li>
                        @else
                            <li>
                                <a href="{{ $url }}" 
                                   class="px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-orange-50 hover:border-orange-300 hover:text-orange-600 transition-colors">
                                    {{ $page }}
                                </a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li>
                    <a href="{{ $paginator->nextPageUrl() }}" 
                       rel="next" 
                       aria-label="@lang('pagination.next')"
                       class="px-3 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-orange-50 hover:border-orange-300 hover:text-orange-600 transition-colors flex items-center gap-1">
                        <span class="hidden sm:inline">Selanjutnya</span>
                        <i class="fas fa-chevron-right text-xs"></i>
                    </a>
                </li>
            @else
                <li>
                    <span class="px-3 py-2 text-sm font-medium text-gray-400 bg-gray-100 rounded-lg cursor-not-allowed flex items-center gap-1">
                        <span class="hidden sm:inline">Selanjutnya</span>
                        <i class="fas fa-chevron-right text-xs"></i>
                    </span>
                </li>
            @endif
        </ul>
    </nav>
@endif
