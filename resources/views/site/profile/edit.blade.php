<x-layouts.site title="My Profile">
    @include('site.partials._account-header')

    @if (session('status'))
        <div class="alert alert-success profile-status">
            <p>{{ session('status') }}</p>
        </div>
    @endif

    @if ($errors->has('avatar'))
        <div class="alert alert-error profile-status">
            <p>{{ $errors->first('avatar') }}</p>
        </div>
    @endif

    @include('site.partials._account-nav')

    <div class="profile-tab-panel active">
        <section class="card">
            <h2 class="section-title">Profile Information</h2>

            @if ($errors->hasAny(['name', 'email', 'phone']))
                <div class="alert alert-error">
                    @if ($errors->has('name')) <p>{{ $errors->first('name') }}</p> @endif
                    @if ($errors->has('email')) <p>{{ $errors->first('email') }}</p> @endif
                    @if ($errors->has('phone')) <p>{{ $errors->first('phone') }}</p> @endif
                </div>
            @endif

            <form method="POST" action="{{ route('profile.update') }}">
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

                <div class="form-group">
                    <label for="phone" class="form-label">Mobile Number</label>
                    <input id="phone" type="text" name="phone" value="{{ old('phone', $user->phone) }}"
                           class="form-control">
                </div>

                <button type="submit" class="btn btn-primary">Save</button>
            </form>
        </section>
    </div>

    <script src="{{ asset('js/avatar-upload.js') }}"></script>
</x-layouts.site>
