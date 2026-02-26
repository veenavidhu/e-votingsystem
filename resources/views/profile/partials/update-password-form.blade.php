<section>
    <header class="mb-4">
        <h3 class="h4 fw-bold text-dark mb-1">
            {{ __('Update Password') }}
        </h3>
        <p class="text-muted small">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-4">
        @csrf
        @method('put')

        <div class="mb-4">
            <label for="update_password_current_password"
                class="form-label fw-bold text-dark small">{{ __('Current Password') }}</label>
            <input id="update_password_current_password" name="current_password" type="password"
                class="form-control border-2 shadow-none" autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')"
                class="text-danger small mt-1" />
        </div>

        <div class="mb-4">
            <label for="update_password_password"
                class="form-label fw-bold text-dark small">{{ __('New Password') }}</label>
            <input id="update_password_password" name="password" type="password"
                class="form-control border-2 shadow-none" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="text-danger small mt-1" />
        </div>

        <div class="mb-4">
            <label for="update_password_password_confirmation"
                class="form-label fw-bold text-dark small">{{ __('Confirm Password') }}</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password"
                class="form-control border-2 shadow-none" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')"
                class="text-danger small mt-1" />
        </div>

        <div class="d-flex align-items-center gap-3">
            <button type="submit" class="btn btn-theme rounded-pill px-4 fw-bold shadow-sm">
                {{ __('Update Password') }}
            </button>

            @if (session('status') === 'password-updated')
                <div class="text-success small fw-bold animate__animated animate__fadeIn">
                    <i class="bi bi-check-circle-fill me-1"></i>{{ __('Saved.') }}
                </div>
            @endif
        </div>
    </form>
</section>