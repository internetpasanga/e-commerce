<x-layouts.admin title="Profile">
    <h1 class="page-title">Profile</h1>

    <div class="max-w-form">
        <nav class="profile-tabs profile-tabs-inline" data-tabs="admin-profile">
            <button type="button" class="profile-tab-btn {{ $errors->hasAny(['current_password', 'password']) ? '' : 'active' }}" data-tab-btn="info">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="4"/><path d="M4 21c0-4 4-6 8-6s8 2 8 6"/></svg>
                <span>Profile Information</span>
            </button>
            <button type="button" class="profile-tab-btn {{ $errors->hasAny(['current_password', 'password']) ? 'active' : '' }}" data-tab-btn="password">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                <span>Change Password</span>
            </button>
        </nav>

        <div class="profile-tab-panel {{ $errors->hasAny(['current_password', 'password']) ? '' : 'active' }}" data-tab-group="admin-profile" data-tab-panel="info">
            <section class="card">
                <h2 class="section-title">Profile Information</h2>

                @if ($errors->hasAny(['name', 'email']))
                    <div class="alert alert-error">
                        @if ($errors->has('name')) <p>{{ $errors->first('name') }}</p> @endif
                        @if ($errors->has('email')) <p>{{ $errors->first('email') }}</p> @endif
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.profile.update') }}">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="name" class="form-label">Name</label>
                        <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}" required
                               class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" required
                               class="form-control">
                    </div>

                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </section>
        </div>

        <div class="profile-tab-panel {{ $errors->hasAny(['current_password', 'password']) ? 'active' : '' }}" data-tab-group="admin-profile" data-tab-panel="password">
            <section class="card">
                <h2 class="section-title">Change Password</h2>

                @if ($errors->hasAny(['current_password', 'password']))
                    <div class="alert alert-error">
                        @if ($errors->has('current_password')) <p>{{ $errors->first('current_password') }}</p> @endif
                        @if ($errors->has('password')) <p>{{ $errors->first('password') }}</p> @endif
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.profile.password') }}">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="current_password" class="form-label">Current Password</label>
                        <input id="current_password" type="password" name="current_password" required class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label">New Password</label>
                        <input id="password" type="password" name="password" required class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="password_confirmation" class="form-label">Confirm New Password</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" required class="form-control">
                    </div>

                    <button type="submit" class="btn btn-primary">Update Password</button>
                </form>
            </section>
        </div>
    </div>

    <script src="{{ asset('js/tabs.js') }}"></script>
</x-layouts.admin>
