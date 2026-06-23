@if ($paginator->hasPages())
<nav aria-label="Navigasi Halaman" class="sg-pagination">

    {{-- ════════════ MOBILE: Prev · [dropdown halaman] · Next ════════════ --}}
    <div class="sg-pagi-mobile">
        {{-- Prev --}}
        @if ($paginator->onFirstPage())
            <span class="sg-pagi-btn sg-pagi-btn--disabled" aria-disabled="true">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="15 18 9 12 15 6"/>
                </svg>
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="sg-pagi-btn" aria-label="Halaman sebelumnya">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="15 18 9 12 15 6"/>
                </svg>
            </a>
        @endif

        {{-- Page selector --}}
        <div class="sg-pagi-selector">
            <label class="sg-pagi-label" for="sg-page-select">Hal</label>
            <select
                id="sg-page-select"
                class="sg-pagi-select"
                aria-label="Pilih halaman"
                onchange="sgGoToPage(this.value)">
                @for ($i = 1; $i <= $paginator->lastPage(); $i++)
                    <option
                        value="{{ $paginator->url($i) }}"
                        {{ $paginator->currentPage() == $i ? 'selected' : '' }}>
                        {{ $i }}
                    </option>
                @endfor
            </select>
            <span class="sg-pagi-total">/ {{ $paginator->lastPage() }}</span>
        </div>

        {{-- Next --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="sg-pagi-btn" aria-label="Halaman berikutnya">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="9 18 15 12 9 6"/>
                </svg>
            </a>
        @else
            <span class="sg-pagi-btn sg-pagi-btn--disabled" aria-disabled="true">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="9 18 15 12 9 6"/>
                </svg>
            </span>
        @endif
    </div>

    {{-- ════════════ DESKTOP: Prev · nomor halaman · Next ════════════ --}}
    <div class="sg-pagi-desktop">
        {{-- Prev --}}
        @if ($paginator->onFirstPage())
            <span class="sg-pagi-btn sg-pagi-btn--disabled" aria-disabled="true">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="15 18 9 12 15 6"/>
                </svg>
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev" class="sg-pagi-btn" aria-label="Halaman sebelumnya">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="15 18 9 12 15 6"/>
                </svg>
            </a>
        @endif

        {{-- Page numbers --}}
        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="sg-pagi-btn sg-pagi-btn--dots" aria-hidden="true">{{ $element }}</span>
            @endif
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="sg-pagi-btn sg-pagi-btn--active" aria-current="page">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="sg-pagi-btn">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next" class="sg-pagi-btn" aria-label="Halaman berikutnya">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="9 18 15 12 9 6"/>
                </svg>
            </a>
        @else
            <span class="sg-pagi-btn sg-pagi-btn--disabled" aria-disabled="true">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="9 18 15 12 9 6"/>
                </svg>
            </span>
        @endif
    </div>

</nav>

{{-- Script sgGoToPage — only inject once per page --}}
@once
<script>
function sgGoToPage(url) {
    if (url && url !== '#') {
        window.location.href = url;
    }
}
</script>
@endonce
@endif
