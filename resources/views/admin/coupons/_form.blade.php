@if ($errors->any())
    <div class="alert alert-error">
        @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    </div>
@endif

<div class="form-group">
    <label for="code" class="form-label">Coupon Code</label>
    <input id="code" type="text" name="code" value="{{ old('code', $coupon->code ?? '') }}" required class="form-control" style="text-transform: uppercase;">
    @error('code') <span class="field-error">{{ $message }}</span> @enderror
</div>

<div class="form-group">
    <label for="type" class="form-label">Discount Type</label>
    <select id="type" name="type" class="form-control" required>
        <option value="percentage" {{ old('type', $coupon->type ?? '') === 'percentage' ? 'selected' : '' }}>Percentage</option>
        <option value="fixed" {{ old('type', $coupon->type ?? '') === 'fixed' ? 'selected' : '' }}>Fixed Amount</option>
    </select>
    @error('type') <span class="field-error">{{ $message }}</span> @enderror
</div>

<div class="form-group">
    <label for="value" class="form-label">Discount Value</label>
    <input id="value" type="number" step="0.01" min="0.01" name="value" value="{{ old('value', $coupon->value ?? '') }}" required class="form-control">
    @error('value') <span class="field-error">{{ $message }}</span> @enderror
    <small style="color: var(--text-muted);">Percentage (e.g. 10 for 10%) or a fixed ₹ amount, depending on the type above.</small>
</div>

<div class="form-group">
    <label for="max_discount" class="form-label">Max Discount (₹)</label>
    <input id="max_discount" type="number" step="0.01" min="0" name="max_discount" value="{{ old('max_discount', $coupon->max_discount ?? '') }}" class="form-control">
    @error('max_discount') <span class="field-error">{{ $message }}</span> @enderror
    <small style="color: var(--text-muted);">Optional cap on the discount amount. Only applies to percentage coupons.</small>
</div>

<div class="form-group">
    <label for="min_order_amount" class="form-label">Minimum Order Amount (₹)</label>
    <input id="min_order_amount" type="number" step="0.01" min="0" name="min_order_amount" value="{{ old('min_order_amount', $coupon->min_order_amount ?? '') }}" class="form-control">
    @error('min_order_amount') <span class="field-error">{{ $message }}</span> @enderror
</div>

<div class="form-group">
    <label for="usage_limit" class="form-label">Total Usage Limit</label>
    <input id="usage_limit" type="number" min="1" name="usage_limit" value="{{ old('usage_limit', $coupon->usage_limit ?? '') }}" class="form-control">
    @error('usage_limit') <span class="field-error">{{ $message }}</span> @enderror
    <small style="color: var(--text-muted);">Leave blank for unlimited redemptions overall.</small>
</div>

<div class="form-group">
    <label for="per_customer_limit" class="form-label">Per-Customer Limit</label>
    <input id="per_customer_limit" type="number" min="1" name="per_customer_limit" value="{{ old('per_customer_limit', $coupon->per_customer_limit ?? 1) }}" class="form-control">
    @error('per_customer_limit') <span class="field-error">{{ $message }}</span> @enderror
    <small style="color: var(--text-muted);">Leave blank for unlimited uses per customer.</small>
</div>

<div class="form-group">
    <label for="starts_at" class="form-label">Starts At</label>
    <input id="starts_at" type="datetime-local" name="starts_at" value="{{ old('starts_at', isset($coupon) && $coupon->starts_at ? $coupon->starts_at->format('Y-m-d\TH:i') : '') }}" class="form-control">
    @error('starts_at') <span class="field-error">{{ $message }}</span> @enderror
</div>

<div class="form-group">
    <label for="expires_at" class="form-label">Expires At</label>
    <input id="expires_at" type="datetime-local" name="expires_at" value="{{ old('expires_at', isset($coupon) && $coupon->expires_at ? $coupon->expires_at->format('Y-m-d\TH:i') : '') }}" class="form-control">
    @error('expires_at') <span class="field-error">{{ $message }}</span> @enderror
</div>

<div class="form-group">
    <label for="is_active" class="form-label">Status</label>
    <select id="is_active" name="is_active" class="form-control">
        <option value="1" {{ old('is_active', $coupon->is_active ?? true) ? 'selected' : '' }}>Active</option>
        <option value="0" {{ ! old('is_active', $coupon->is_active ?? true) ? 'selected' : '' }}>Inactive</option>
    </select>
</div>
