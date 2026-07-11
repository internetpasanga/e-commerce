<x-layouts.admin title="Edit Coupon">
    <h1 class="page-title">Edit Coupon</h1>

    <div class="max-w-form-lg card">
        <form method="POST" action="{{ route('admin.coupons.update', $coupon) }}">
            @csrf
            @method('PUT')

            @include('admin.coupons._form')

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Save</button>
                <a href="{{ route('admin.coupons.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>

    <div class="max-w-form-lg card" style="margin-top: 1.5rem;">
        <h2 class="section-title">Usage</h2>
        <p>Redeemed <strong>{{ $coupon->used_count }}</strong> time{{ $coupon->used_count === 1 ? '' : 's' }}@if ($coupon->usage_limit) out of a limit of {{ $coupon->usage_limit }}@endif.</p>
    </div>
</x-layouts.admin>
