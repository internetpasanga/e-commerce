<x-layouts.admin title="Edit FAQ">
    <h1 class="page-title">Edit FAQ</h1>

    <div class="max-w-form-lg card">
        <form method="POST" action="{{ route('admin.faqs.update', $faq) }}">
            @csrf
            @method('PUT')

            @include('admin.faqs._form')

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Save</button>
                <a href="{{ route('admin.faqs.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>

    <script src="{{ asset('js/rich-text-editor.js') }}"></script>
</x-layouts.admin>
