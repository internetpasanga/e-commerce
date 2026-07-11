<x-layouts.admin title="Add Coupon">
    <h1 class="page-title">Add Coupon</h1>

    <div class="max-w-form-lg card">
        <form method="POST" action="{{ route('admin.coupons.store') }}">
            @csrf

            @include('admin.coupons._form')

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Save</button>
                <a href="{{ route('admin.coupons.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</x-layouts.admin>
