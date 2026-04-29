@if ($paginator->hasPages())
    <div class="custom-pagination">
        {{-- <div class="pagination-info">
             {{ $paginator->currentPage() }}  {{ $paginator->lastPage() }}
        </div> --}}
        
        <div class="pagination-buttons">
            {{-- Кнопка "Назад" --}}
            @if ($paginator->onFirstPage())
                <span class="pagination-btn disabled">←</span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="pagination-btn">←</a>
            @endif

            {{-- Номера страниц (только ближайшие) --}}
            @foreach ($elements as $element)
                @if (is_string($element))
                    <span class="pagination-dots">...</span>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="pagination-btn page active">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="pagination-btn page">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Кнопка "Вперед" --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="pagination-btn">→</a>
            @else
                <span class="pagination-btn disabled">→</span>
            @endif
        </div>
    </div>
@endif