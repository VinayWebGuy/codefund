@if ($paginator->hasPages())

    <style>
        .pagination-container {
            display: flex;
            justify-content: center;
            margin: 20px 0;
            width: 100%;
        }

        .pagination {
            list-style: none;
            padding: 0;
            display: flex;
            gap: 5px;
        }

        .pagination .page-item {
            display: inline-block;
        }

        .pagination .page-item a,
        .pagination .page-item span {
            padding: 10px 15px;
            border: 1px solid #ddd;
            color: #087cb6;
            text-decoration: none;
            font-size: 14px;
            transition: background-color 0.3s ease;
        }

        .pagination .page-item.active span {
            background-color: #087cb6;
            color: white;
            border-color: #087cb6;
        }

        .pagination .page-item.disabled span,
        .pagination .page-item.disabled a {
            color: #6c757d;
            pointer-events: none;
            background-color: #f8f9fa;
            border-color: #ddd;
        }

        .pagination .page-item a:hover {
            background-color: rgb(4, 75, 151);
            color: white;
        }

        .pagination .page-item:first-child a,
        .pagination .page-item:first-child span {
            border-radius: 5px 0 0 5px;
        }

        .pagination .page-item:last-child a,
        .pagination .page-item:last-child span {
            border-radius: 0 5px 5px 0;
        }
    </style>
    <nav class="pagination-container" aria-label="Page navigation example">
        <ul class="pagination">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled"><span class="page-link">&laquo;</span></li>
            @else
                <li class="page-item"><a class="page-link" href="{{ $paginator->previousPageUrl() }}"
                        rel="prev">&laquo;</a></li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="page-item disabled"><span class="page-link">{{ $element }}</span></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                        @else
                            <li class="page-item"><a class="page-link"
                                    href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item"><a class="page-link" href="{{ $paginator->nextPageUrl() }}"
                        rel="next">&raquo;</a></li>
            @else
                <li class="page-item disabled"><span class="page-link">&raquo;</span></li>
            @endif
        </ul>
    </nav>
@endif
