@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex items-center justify-between">
        <div class="d-flex justify-content-between">
            @if ($paginator->onFirstPage())
                <span class="btn btn-outline-secondary btn-sm disabled mx-4">
                    {!! __('pagination.previous') !!}
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="btn btn-outline-secondary btn-sm mx-4">
                    {!! __('pagination.previous') !!}
                </a>
            @endif
        
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="btn btn-outline-secondary btn-sm mx-4">
                    {!! __('pagination.next') !!}
                </a>
            @else
                <span class="btn btn-outline-secondary btn-sm disabled mx-4">
                    {!! __('pagination.next') !!}
                </span>
            @endif
        </div>
          
        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
            <div class="d-flex justify-content-center">
                <p class="text-sm text-gray-700 leading-5 dark:text-gray-400">
                    {!! __('Showing') !!}
                    @if ($paginator->firstItem())
                        <span class="font-medium">{{ $paginator->firstItem() }}</span>
                        {!! __('to') !!}
                        <span class="font-medium">{{ $paginator->lastItem() }}</span>
                    @else
                        {{ $paginator->count() }}
                    @endif
                    {!! __('of') !!}
                    <span class="font-medium">{{ $paginator->total() }}</span>
                    {!! __('results') !!}
                </p>
            </div>

            <div class="d-flex justify-content-center">
                <nav aria-label="Page navigation">
                    <ul class="pagination pagination-sm">
            
                        {{-- Previous Page Link --}}
                        @if ($paginator->onFirstPage())
                            <li class="page-item disabled">
                                <span class="page-link" aria-hidden="true">&laquo;</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="{{ __('pagination.previous') }}">&laquo;</a>
                            </li>
                        @endif
            
                        {{-- Pagination Elements --}}
                        @foreach ($elements as $element)
                            {{-- "Three Dots" Separator --}}
                            @if (is_string($element))
                                <li class="page-item disabled">
                                    <span class="page-link">{{ $element }}</span>
                                </li>
                            @endif
            
                            {{-- Array Of Links --}}
                            @if (is_array($element))
                                @foreach ($element as $page => $url)
                                    @if ($page == $paginator->currentPage())
                                        <li class="page-item active" aria-current="page">
                                            <span class="page-link">{{ $page }}</span>
                                        </li>
                                    @else
                                        <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                                    @endif
                                @endforeach
                            @endif
                        @endforeach
            
                        {{-- Next Page Link --}}
                        @if ($paginator->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="{{ __('pagination.next') }}">&raquo;</a>
                            </li>
                        @else
                            <li class="page-item disabled">
                                <span class="page-link" aria-hidden="true">&raquo;</span>
                            </li>
                        @endif
            
                    </ul>
                </nav>
            </div>
        </div>
    </nav>
@endif
