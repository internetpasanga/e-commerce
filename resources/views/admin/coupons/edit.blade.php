<x-layouts.admin title="Edit Coupon">
    <div class="page-header">
        <h1 class="page-title">Edit Coupon</h1>
        <a href="{{ route('admin.coupons.index') }}" class="btn btn-secondary">&larr; Back to Coupons</a>
    </div>

    <form method="POST" action="{{ route('admin.coupons.update', $coupon) }}" class="max-w-form-lg">
        @csrf
        @method('PUT')

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

    <div class="max-w-form-lg card card-flush" style="margin-top: 1.5rem;">
        <div class="card-header">
            <h2 class="card-title">Usage</h2>
        </div>
        <div class="card-body">
            <p>Redeemed <strong>{{ $coupon->used_count }}</strong> time{{ $coupon->used_count === 1 ? '' : 's' }}@if ($coupon->usage_limit) out of a limit of {{ $coupon->usage_limit }}@endif.</p>
        </div>
    </div>
</x-layouts.admin>
