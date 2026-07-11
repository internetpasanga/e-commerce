<label for="{{ $idPrefix }}-address-{{ $address->id }}" class="address-option">
    <input type="radio" id="{{ $idPrefix }}-address-{{ $address->id }}" name="{{ $groupName }}" value="{{ $address->id }}" {{ $checked ? 'checked' : '' }}>
    <div class="address-option-body">
        <div class="address-option-header">
            <strong>{{ $address->label }}</strong>
            @if ($address->is_default)
                <span class="badge badge-success">Default</span>
            @endif
        </div>
        <p class="address-option-text">{{ $address->name }} &middot; {{ $address->phone }}</p>
        <p class="address-option-text">
            {{ $address->address_line1 }}@if ($address->address_line2), {{ $address->address_line2 }}@endif,
            {{ $address->city }}, {{ $address->state }} {{ $address->postal_code }}, {{ $address->country }}
        </p>
    </div>
</label>
