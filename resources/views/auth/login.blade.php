<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="alert alert-info mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <h3 class="text-center mb-4 font-weight-bold">Login</h3>

        <!-- Email Address -->
        <div class="mb-3">
            <label for="email" class="form-label font-weight-bold">Email / Username</label>
            <input id="email" class="form-control form-control-lg border-2 shadow-none" type="email" name="email"
                value="{{ old('email') }}" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="text-danger mt-1 small" />
        </div>

        <!-- Password -->
        <div class="mb-3">
            <label for="password" class="form-label font-weight-bold">Password</label>
            <input id="password" class="form-control form-control-lg border-2 shadow-none" type="password"
                name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="text-danger mt-1 small" />
        </div>

        <!-- Remember Me -->
        <div class="form-check mb-4">
            <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
            <label for="remember_me" class="form-check-label text-muted small">Keep me logged in</label>
        </div>

        <div class="d-grid">
            <button type="submit" class="btn btn-theme btn-lg rounded-pill font-weight-bold shadow-sm py-3 uppercase">
                Sign In
            </button>
        </div>

        <div class="text-center mt-4">
            @if (Route::has('register'))
                <p class="mb-2 text-muted">
                    New to E-voting?
                    <a href="{{ route('register') }}" class="text-primary font-weight-bold text-decoration-none">Create an
                        Account</a>
                </p>
            @endif

            @if (Route::has('password.request'))
                <a class="text-muted small text-decoration-none hover-primary" href="{{ route('password.request') }}">
                    Forgot your password?
                </a>
            @endif
        </div>
    </form>
</x-guest-layout>