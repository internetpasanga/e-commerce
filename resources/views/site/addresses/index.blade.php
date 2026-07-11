<x-layouts.site title="Saved Addresses">
    @include('site.partials._account-header')

    @if (session('status'))
        <div class="alert alert-success profile-status">
            <p>{{ session('status') }}</p>
        </div>
    @endif

    @include('site.partials._account-nav')

    <div class="profile-tab-panel active">
        <section class="card">
            <div class="page-header">
                <h2 class="section-title">Saved Addresses</h2>
                <a href="{{ route('addresses.create') }}" class="btn btn-primary">Add Address</a>
            </div>

            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Label</th>
                            <th>Name</th>
                            <th>Address</th>
                            <th>Phone</th>
                            <th>Default</th>
                            <th class="text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($addresses as $address)
                            <tr>
                                <td>{{ $address->label }}</td>
                                <td>{{ $address->name }}</td>
                                <td>
                                    {{ $address->address_line1 }}@if ($address->address_line2), {{ $address->address_line2 }}@endif,
                                    {{ $address->city }}, {{ $address->state }} {{ $address->postal_code }}, {{ $address->country }}
                                </td>
                                <td>{{ $address->phone }}</td>
                                <td>
                                    @if ($address->is_default)
                                        <span class="badge badge-success">Default</span>
                                    @endif
                                </td>
                                <td class="text-right">
                                    <div class="row-actions">
                                        <a href="{{ route('addresses.edit', $address) }}" class="btn-icon" title="Edit">
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 20h9"/><path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L7 19l-4 1 1-4z"/></svg>
                                        </a>
                                        <form method="POST" action="{{ route('addresses.destroy', $address) }}"
                                              onsubmit="return confirm('Delete this address? This cannot be undone.');" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-icon danger" title="Delete">
                                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/><path d="M10 11v6"/><path d="M14 11v6"/></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="empty-row">No saved addresses yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </div>

    <script src="{{ asset('js/avatar-upload.js') }}"></script>
</x-layouts.site>
