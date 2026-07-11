<x-layouts.admin title="Add FAQ">
    <h1 class="page-title">Add FAQ</h1>

    <div class="max-w-form-lg card">
        <form method="POST" action="{{ route('admin.faqs.store') }}">
            @csrf

            @include('admin.faqs._form')

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Save</button>
                <a href="{{ route('admin.faqs.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>

    <script src="{{ asset('js/rich-text-editor.js') }}"></script>
</x-layouts.admin>
