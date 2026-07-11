@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="pagination">
        <p class="pagination-summary">
            {{ __('Showing') }}
            <strong>{{ $paginator->firstItem() ?? 0 }}</strong>
            {{ __('to') }}
            <strong>{{ $paginator->lastItem() ?? 0 }}</strong>
            {{ __('of') }}
            <strong>{{ $paginator->total() }}</strong>
            {{ __('results') }}
        </p>

        <div class="pagination-nav">
            <a href="{{ $paginator->onFirstPage() ? '' : $paginator->previousPageUrl() }}"
               rel="prev"
               class="pagination-link pagination-prev {{ $paginator->onFirstPage() ? 'disabled' : '' }}"
               @if ($paginator->onFirstPage()) aria-disabled="true" tabindex="-1" @endif
               aria-label="Previous">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"/></svg>
                <span class="pagination-prev-next-label">Previous</span>
            </a>

            <div class="pagination-pages">
                @foreach ($elements as $element)
                    @if (is_string($element))
                        <span class="pagination-dots">{{ $element }}</span>
                    @endif

                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <span class="pagination-link pagination-page is-current" aria-current="page">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}" class="pagination-link pagination-page" aria-label="{{ __('Go to page :page', ['page' => $page]) }}">{{ $page }}</a>
                            @endif
                        @endforeach
                    @endif
                @endforeach
            </div>

            <a href="{{ $paginator->hasMorePages() ? $paginator->nextPageUrl() : '' }}"
               rel="next"
               class="pagination-link pagination-next {{ $paginator->hasMorePages() ? '' : 'disabled' }}"
               @if (! $paginator->hasMorePages()) aria-disabled="true" tabindex="-1" @endif
               aria-label="Next">
                <span class="pagination-prev-next-label">Next</span>
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"/></svg>
            </a>
        </div>
    </nav>
@endif
