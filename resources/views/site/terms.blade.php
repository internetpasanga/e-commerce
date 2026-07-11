<x-layouts.site :title="$title">
    <p class="breadcrumb"><a href="{{ route('home') }}">Home</a> / {{ $title }}</p>
    <h1 class="page-title">{{ $title }}</h1>

    <div class="card" style="max-width: 800px; margin: 0 auto;">
        {!! $content !!}
    </div>
</x-layouts.site>
