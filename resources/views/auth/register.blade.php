<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <h3 class="text-center mb-4 font-weight-bold">Register</h3>

        <!-- Name -->
        <div class="mb-3">
            <label for="name" class="form-label font-weight-bold">Full Name</label>
            <input id="name" class="form-control border-2 shadow-none" type="text" name="name" value="{{ old('name') }}"
                required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="text-danger mt-1 small" />
        </div>

        <!-- Email Address -->
        <div class="mb-3">
            <label for="email" class="form-label font-weight-bold">Email Address</label>
            <input id="email" class="form-control border-2 shadow-none" type="email" name="email"
                value="{{ old('email') }}" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="text-danger mt-1 small" />
        </div>

        <!-- Password -->
        <div class="mb-3">
            <label for="password" class="form-label font-weight-bold">Password</label>
            <input id="password" class="form-control border-2 shadow-none" type="password" name="password" required
                autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="text-danger mt-1 small" />
        </div>

        <!-- Confirm Password -->
        <div class="mb-4">
            <label for="password_confirmation" class="form-label font-weight-bold">Confirm Password</label>
            <input id="password_confirmation" class="form-control border-2 shadow-none" type="password"
                name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="text-danger mt-1 small" />
        </div>

        <div class="d-grid">
            <button type="submit" class="btn btn-theme btn-lg rounded-pill font-weight-bold shadow-sm py-3 uppercase">
                Register Now
            </button>
        </div>

        <div class="text-center mt-4">
            <a class="text-muted small text-decoration-none" href="{{ route('login') }}">
                Already registered? <span class="text-primary font-weight-bold">Log in</span>
            </a>
        </div>
    </form>
</x-guest-layout>