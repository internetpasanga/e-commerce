<x-layouts.site title="Verify Email">
    <p class="breadcrumb"><a href="{{ route('home') }}">Home</a> / Verify Email</p>

    <div class="auth-page">
        <div class="auth-card card">
            <h1 class="section-title">Verify your email</h1>

            <p>Thanks for registering! Please check your email for a verification link before logging in.</p>

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

            <p>Didn't receive the email?</p>

            <form method="POST" action="{{ route('verification.send') }}">
                @csrf

                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <input id="email" type="email" name="email" required class="form-control">
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%;">Resend Verification Email</button>
            </form>

            <div class="auth-card-links">
                <p><a href="{{ route('login') }}">Back to login</a></p>
            </div>
        </div>
    </div>
</x-layouts.site>
