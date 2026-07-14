<x-layouts.site title="Verify Email">
    <p class="breadcrumb"><a href="{{ route('home') }}">Home</a> / Verify Email</p>

    <div class="auth-page">
        <div class="auth-card card">
            <h1 class="section-title">Verify your email</h1>

            <p>We've sent a 6-digit verification code to <strong>{{ $email }}</strong>. Enter it below to activate your account.</p>

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

            <form method="POST" action="{{ route('verification.verify') }}">
                @csrf

                <div class="form-group">
                    <label for="otp" class="form-label">Verification Code</label>
                    <input id="otp" type="text" name="otp" required autofocus
                           inputmode="numeric" pattern="[0-9]*" maxlength="6"
                           class="form-control otp-input" placeholder="000000">
                </div>

                <button type="submit" class="btn btn-primary" style="width: 100%;">Verify Email</button>
            </form>

            <p style="margin-top: 1.25rem;">Didn't receive the code?</p>

            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="btn btn-secondary" style="width: 100%;">Resend Code</button>
            </form>

            <div class="auth-card-links">
                <p><a href="{{ route('login') }}">Back to login</a></p>
            </div>
        </div>
    </div>
</x-layouts.site>
