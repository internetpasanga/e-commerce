<x-layouts.admin title="Edit Product">
    <h1 class="page-title">Edit Product</h1>

    <div class="max-w-form-lg card">
        <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            @include('admin.products._form')

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Save</button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>

    <script src="{{ asset('js/searchable-select.js') }}"></script>
    <script src="{{ asset('js/rich-text-editor.js') }}"></script>
    <script src="{{ asset('js/product-form.js') }}"></script>
    <script src="{{ asset('js/product-specs-form.js') }}"></script>
</x-layouts.admin>
