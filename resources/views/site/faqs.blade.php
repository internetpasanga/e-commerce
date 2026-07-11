<x-layouts.site title="FAQs">
    <p class="breadcrumb"><a href="{{ route('home') }}">Home</a> / FAQs</p>
    <h1 class="page-title">Frequently Asked Questions</h1>

    <div class="faq-list">
        @forelse ($faqs as $faq)
            <details class="faq-item">
                <summary class="faq-question">{{ $faq->question }}</summary>
                <div class="faq-answer">{!! $faq->answer !!}</div>
            </details>
        @empty
            <p>No FAQs available yet.</p>
        @endforelse
    </div>
</x-layouts.site>
