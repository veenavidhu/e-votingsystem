<section>
    <header class="mb-4">
        <h3 class="h4 fw-bold text-dark mb-1">
            {{ __('Profile Information') }}
        </h3>
        <p class="text-muted small">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-4">
        @csrf
        @method('patch')

        <div class="mb-4">
            <label for="name" class="form-label fw-bold text-dark small">{{ __('Name') }}</label>
            <input id="name" name="name" type="text" class="form-control border-2 shadow-none"
                value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" />
            <x-input-error class="text-danger small mt-1" :messages="$errors->get('name')" />
        </div>

        <div class="mb-4">
            <label for="email" class="form-label fw-bold text-dark small">{{ __('Email') }}</label>
            <input id="email" name="email" type="email" class="form-control border-2 shadow-none"
                value="{{ old('email', $user->email) }}" required autocomplete="username" />
            <x-input-error class="text-danger small mt-1" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                <div class="mt-3 alert alert-warning py-2 small border-0 rounded-3">
                    <p class="mb-1 text-dark">
                        {{ __('Your email address is unverified.') }}
                    </p>
                    <button form="send-verification" class="btn btn-link p-0 text-decoration-none small fw-bold">
                        {{ __('Click here to re-send the verification email.') }}
                    </button>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 text-success fw-bold small">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="d-flex align-items-center gap-3">
            <button type="submit" class="btn btn-theme rounded-pill px-4 fw-bold shadow-sm">
                {{ __('Save Changes') }}
            </button>

            @if (session('status') === 'profile-updated')
                <div class="text-success small fw-bold animate__animated animate__fadeIn">
                    <i class="bi bi-check-circle-fill me-1"></i>{{ __('Saved.') }}
                </div>
            @endif
        </div>
    </form>
</section>