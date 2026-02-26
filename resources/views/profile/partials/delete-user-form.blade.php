<section>
    <header class="mb-4">
        <h3 class="h4 fw-bold text-danger mb-1">
            {{ __('Delete Account') }}
        </h3>
        <p class="text-muted small">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted.') }}
        </p>
    </header>

    <button type="button" class="btn btn-outline-danger rounded-pill px-4 fw-bold" data-bs-toggle="modal"
        data-bs-target="#confirmUserDeletionModal">
        {{ __('Delete Account') }}
    </button>

    <!-- Delete Account Modal -->
    <div class="modal fade" id="confirmUserDeletionModal" tabindex="-1" aria-labelledby="confirmUserDeletionModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form method="post" action="{{ route('profile.destroy') }}" class="modal-content border-0 shadow rounded-4">
                @csrf
                @method('delete')

                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold" id="confirmUserDeletionModalLabel">{{ __('Confirm Deletion') }}</h5>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>

                <div class="modal-body py-4">
                    <p class="text-secondary small mb-4">
                        {{ __('Are you sure you want to delete your account? This action is permanent and cannot be undone. Please enter your password to confirm.') }}
                    </p>

                    <div class="mb-0">
                        <label for="password"
                            class="form-label fw-bold text-dark small mb-1 sr-only">{{ __('Password') }}</label>
                        <input id="password" name="password" type="password" class="form-control border-2 shadow-none"
                            placeholder="{{ __('Your Password') }}" required />
                        <x-input-error :messages="$errors->userDeletion->get('password')"
                            class="text-danger small mt-1" />
                    </div>
                </div>

                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-theme-outline rounded-pill px-4"
                        data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                    <button type="submit" class="btn btn-danger rounded-pill px-4 fw-bold">
                        {{ __('Delete Permanently') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>