@php
    // Reusable star-rating display.
    //   $rating — average rating (0–5 float)
    //   $count  — optional review count to show beside the stars
    //   $showEmpty — when false (default), renders nothing if there are no reviews
    $rating = (float) ($rating ?? 0);
    $count = $count ?? null;
    $showEmpty = $showEmpty ?? false;
    $pct = max(0, min(100, $rating / 5 * 100));
@endphp

@if ($rating > 0 || $showEmpty)
    <span class="stars-row">
        <span class="stars" role="img" aria-label="{{ number_format($rating, 1) }} out of 5 stars">
            <span class="stars-track">★★★★★</span>
            <span class="stars-fill" style="width: {{ $pct }}%">★★★★★</span>
        </span>
        @if (! is_null($count))
            <span class="stars-count">{{ number_format((int) $count) }}</span>
        @endif
    </span>
@endif
