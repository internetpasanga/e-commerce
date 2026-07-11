<x-layouts.site title="Reset Password">
    <p class="breadcrumb"><a href="{{ route('home') }}">Home</a> / Reset Password</p>

    <div class="auth-page">
        <div class="auth-card card">
            <h1 class="section-title">Reset Password</h1>

            @if ($errors->any())
                <div class="alert alert-error">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('password.store') }}">
                @csrf

                <input type="hidden" name="token" value="{{ $token }}">

                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email', $email) }}" required autofocus class="form-control">
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">New Password</label>
                    <input id="password" type="password" name="password" required class="form-control">
                </div>

                <div class="form-group">
                    <label for="password_confirmation" class="form-label">Confirm New Password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required class="form-control">
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%;">Reset Password</button>
            </form>
        </div>
    </div>
</x-layouts.site>
