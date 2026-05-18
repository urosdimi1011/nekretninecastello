@if ($paginator->hasPages())
    <nav class="custom-pagination">
        <ul class="pagination-list">

            @if ($paginator->onFirstPage())
                <li class="disabled"><span>&laquo;</span></li>
            @else
                <li><a href="{{ $paginator->previousPageUrl() }}">&laquo;</a></li>
            @endif

            @php
                $current = $paginator->currentPage();
                $last = $paginator->lastPage();
                $dots1 = false;
                $dots2 = false;
            @endphp

            @for ($i = 1; $i <= $last; $i++)
                @if ($i === 1 || $i === $last || ($i >= $current - 1 && $i <= $current + 1))
                    <li @if ($i === $current) class="active" @endif>
                        @if ($i === $current)
                            <span>{{ $i }}</span>
                        @else
                            <a href="{{ $paginator->url($i) }}">{{ $i }}</a>
                        @endif
                    </li>
                @elseif ($i > 1 && $i < $current - 1 && !$dots1)
                    @php $dots1 = true @endphp
                    <li class="disabled"><span>...</span></li>
                @elseif ($i < $last && $i > $current + 1 && !$dots2)
                    @php $dots2 = true @endphp
                    <li class="disabled"><span>...</span></li>
                @endif
            @endfor

            @if ($paginator->hasMorePages())
                <li><a href="{{ $paginator->nextPageUrl() }}">&raquo;</a></li>
            @else
                <li class="disabled"><span>&raquo;</span></li>
            @endif

        </ul>
    </nav>
@endif
