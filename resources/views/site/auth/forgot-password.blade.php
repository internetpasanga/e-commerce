<x-layouts.site title="Forgot Password">
    <p class="breadcrumb"><a href="{{ route('home') }}">Home</a> / Forgot Password</p>

    <div class="auth-page">
        <div class="auth-card card">
            <h1 class="section-title">Forgot Password</h1>

            <p>Enter your email address and we'll send you a link to reset your password.</p>

            @if (session('status'))
                <div class="alert alert-success">
                    <p>{{ session('status') }}</p>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-error">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus class="form-control">
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%;">Send Reset Link</button>
            </form>

            <div class="auth-card-links">
                <p><a href="{{ route('login') }}">Back to login</a></p>
            </div>
        </div>
    </div>
</x-layouts.site>
