<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class CustomerController extends Controller
{
    public function index(Request $request): View
    {
        $customers = User::where('is_admin', false)
            ->when($request->filled('search'), fn ($query) => $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%'.$request->input('search').'%')
                    ->orWhere('email', 'like', '%'.$request->input('search').'%');
            }))
            ->withCount('orders')
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.customers.index', compact('customers'));
    }

    public function create(): View
    {
        return view('admin.customers.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'phone' => ['nullable', 'string', 'max:20'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $customer = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'password' => $validated['password'],
            'is_admin' => false,
        ]);

        // Admin-created accounts are vouched for, so they're marked verified
        // immediately (not mass-assigned above — email_verified_at is
        // intentionally excluded from $fillable).
        $customer->forceFill(['email_verified_at' => now()])->save();

        return redirect()->route('admin.customers.index')->with('status', 'Customer created successfully.');
    }

    public function edit(User $customer): View
    {
        abort_if($customer->is_admin, 404);

        $customer->load([
            'addresses' => fn ($query) => $query->orderByDesc('is_default'),
            'orders' => fn ($query) => $query->latest()->take(10),
        ]);

        return view('admin.customers.edit', compact('customer'));
    }

    public function update(Request $request, User $customer): RedirectResponse
    {
        abort_if($customer->is_admin, 404);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', Rule::unique('users')->ignore($customer->id)],
            'phone' => ['nullable', 'string', 'max:20'],
            'password' => ['nullable', 'confirmed', Password::defaults()],
        ]);

        if (! $request->filled('password')) {
            unset($validated['password']);
        }

        $customer->update($validated);

        return redirect()->route('admin.customers.edit', $customer)->with('status', 'Customer updated successfully.');
    }
}
