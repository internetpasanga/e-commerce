<x-layouts.admin title="Add Coupon">
    <div class="page-header">
        <h1 class="page-title">Add Coupon</h1>
        <a href="{{ route('admin.coupons.index') }}" class="btn btn-secondary">&larr; Back to Coupons</a>
    </div>

    <form method="POST" action="{{ route('admin.coupons.store') }}" class="max-w-form-lg">
        @csrf

        <div class="card card-flush">
            <div class="card-header">
                <h2 class="card-title">Coupon Details</h2>
            </div>
            <div class="card-body">
                @include('admin.coupons._form')
            </div>
            <div class="card-footer form-actions">
                <button type="submit" class="btn btn-primary">Save Coupon</button>
                <a href="{{ route('admin.coupons.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </div>
    </form>
</x-layouts.admin>
