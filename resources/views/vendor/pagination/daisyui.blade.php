@if ($paginator->hasPages())
    <div class="mt-6 flex justify-center">
        <div class="join">

            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <button class="join-item btn btn-sm btn-disabled">← Prev</button>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="join-item btn btn-sm">← Prev</a>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($paginator->getUrlRange(1, $paginator->lastPage()) as $page => $url)
                @if ($page == $paginator->currentPage())
                    <button class="join-item btn btn-sm btn-primary">{{ $page }}</button>
                @else
                    <a href="{{ $url }}" class="join-item btn btn-sm">{{ $page }}</a>
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="join-item btn btn-sm">Next →</a>
            @else
                <button class="join-item btn btn-sm btn-disabled">Next →</button>
            @endif

        </div>
    </div>
@endif
