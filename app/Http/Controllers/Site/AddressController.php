<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Address;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AddressController extends Controller
{
    public function index(Request $request): View
    {
        $addresses = $request->user()->addresses()->orderByDesc('is_default')->latest()->get();

        return view('site.addresses.index', compact('addresses'));
    }

    public function create(): View
    {
        return view('site.addresses.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateAddress($request);

        $user = $request->user();

        if ($validated['is_default']) {
            $user->addresses()->update(['is_default' => false]);
        }

        $user->addresses()->create($validated);

        if ($request->input('redirect') === 'checkout') {
            return redirect()->route('checkout.create')->with('status', 'Address added successfully.');
        }

        return redirect()->route('addresses.index')->with('status', 'Address added successfully.');
    }

    public function edit(Request $request, Address $address): View
    {
        abort_if($address->user_id !== $request->user()->id, 403);

        return view('site.addresses.edit', compact('address'));
    }

    public function update(Request $request, Address $address): RedirectResponse
    {
        abort_if($address->user_id !== $request->user()->id, 403);

        $validated = $this->validateAddress($request);

        if ($validated['is_default']) {
            $request->user()->addresses()->where('id', '!=', $address->id)->update(['is_default' => false]);
        }

        $address->update($validated);

        return redirect()->route('addresses.index')->with('status', 'Address updated successfully.');
    }

    public function destroy(Request $request, Address $address): RedirectResponse
    {
        abort_if($address->user_id !== $request->user()->id, 403);

        $address->delete();

        return back()->with('status', 'Address deleted successfully.');
    }

    private function validateAddress(Request $request): array
    {
        return $request->validate([
            'label' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:30'],
            'address_line1' => ['required', 'string', 'max:255'],
            'address_line2' => ['nullable', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'state' => ['required', 'string', 'max:255'],
            'postal_code' => ['required', 'string', 'max:20'],
            'country' => ['required', 'string', 'max:255'],
            'is_default' => ['sometimes', 'boolean'],
        ]) + ['is_default' => $request->boolean('is_default')];
    }
}
