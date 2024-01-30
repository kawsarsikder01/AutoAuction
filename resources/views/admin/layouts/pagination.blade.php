<nav id="datatablePagination" aria-label="Activity pagination">
    <div class="dataTables_paginate paging_simple_numbers" id="datatable_paginate">
    @if ($paginator->hasPages())
    <ul id="datatable_pagination" class="pagination datatable-custom-pagination">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
            <li class="paginate_item page-item">
                <a class="paginate_button previous page-link disabled"  aria-controls="datatable" data-dt-idx="0" tabindex="0" id="datatable_previous"><span aria-hidden="true">Prev</span></a>
            </li>
            @else
            <li class="paginate_item page-item">
                <a class="paginate_button previous page-link" href="{{ $paginator->previousPageUrl() }}" aria-controls="datatable" data-dt-idx="0" tabindex="0" id="datatable_previous"><span aria-hidden="true">Prev</span></a>
            </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class=" page-item">
                        <a href="#" class="page-link">{{ $element }}</a>
                    </li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active">
                                <a href="#" class="page-link">{{ $page }}<span class="sr-only">(current)</span></a>
                            </li>
                        @else
                            <li class="page-item">
                                <a href="{{ $url}}" class="page-link">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
            <li class="paginate_item page-item">
                <a class="paginate_button next page-link" href="{{ $paginator->nextPageUrl() }}" aria-controls="datatable" data-dt-idx="4" tabindex="0" id="datatable_next"><span aria-hidden="true">Next</span></a>
            </li>
            @else
            <li class="paginate_item page-item disabled">
                <a class="paginate_button next page-link" href="{{ $paginator->nextPageUrl() }}" aria-controls="datatable" data-dt-idx="4" tabindex="0" id="datatable_next"><span aria-hidden="true">Next</span></a>
            </li>
            @endif
        </ul>
    @endif
    </div>
</nav>
