<x-layouts.site title="Add Address">
    <div class="max-w-form-lg card" style="margin: 2rem auto;">
        <h1 class="page-title">Add Address</h1>

        <form method="POST" action="{{ route('addresses.store') }}">
            @csrf
            <input type="hidden" name="redirect" value="{{ request('redirect') }}">

            @include('site.addresses._form')

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Save</button>
                <a href="{{ request('redirect') === 'checkout' ? route('checkout.create') : route('addresses.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</x-layouts.site>
