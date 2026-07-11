<x-layouts.site title="Change Password">
    @include('site.partials._account-header')

    @if (session('status'))
        <div class="alert alert-success profile-status">
            <p>{{ session('status') }}</p>
        </div>
    @endif

    @include('site.partials._account-nav')

    <div class="profile-tab-panel active">
        <section class="card">
            <h2 class="section-title">Change Password</h2>

            @if ($errors->hasAny(['current_password', 'password']))
                <div class="alert alert-error">
                    @if ($errors->has('current_password')) <p>{{ $errors->first('current_password') }}</p> @endif
                    @if ($errors->has('password')) <p>{{ $errors->first('password') }}</p> @endif
                </div>
            @endif

            <form method="POST" action="{{ route('profile.password') }}">
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

    <script src="{{ asset('js/avatar-upload.js') }}"></script>
</x-layouts.site>
