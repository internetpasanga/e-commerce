<x-layouts.site title="Edit Address">
    <div class="max-w-form-lg card" style="margin: 2rem auto;">
        <h1 class="page-title">Edit Address</h1>

        <form method="POST" action="{{ route('addresses.update', $address) }}">
            @csrf
            @method('PUT')

            @include('site.addresses._form')

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Save</button>
                <a href="{{ route('addresses.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</x-layouts.site>
