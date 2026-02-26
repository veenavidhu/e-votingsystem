<x-app-layout>
    <x-slot name="header">
        {{ __('Edit User Settings') }}
    </x-slot>

    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-lg-6 mx-auto">
                <div class="mb-4">
                    <a href="{{ route('admin.users.index') }}" class="text-muted text-decoration-none small">
                        <i class="bi bi-arrow-left me-1"></i>Back to User List
                    </a>
                </div>

                <div class="card border-0 rounded-4 shadow-sm">
                    <div class="card-body p-4 p-md-5">
                        <header class="mb-4">
                            <h3 class="h4 fw-bold text-dark mb-1">Edit Account: {{ $user->name }}</h3>
                            <p class="text-muted small">Modify user role and information or update security credentials.
                            </p>
                        </header>

                        <form method="POST" action="{{ route('admin.users.update', $user) }}">
                            @csrf
                            @method('PATCH')

                            <div class="mb-4">
                                <label for="name"
                                    class="form-label fw-bold text-dark small">{{ __('Full Name') }}</label>
                                <input id="name" name="name" type="text" class="form-control border-2 shadow-none"
                                    value="{{ old('name', $user->name) }}" required />
                                <x-input-error class="text-danger small mt-1" :messages="$errors->get('name')" />
                            </div>

                            <div class="mb-4">
                                <label for="email"
                                    class="form-label fw-bold text-dark small">{{ __('Email Address') }}</label>
                                <input id="email" name="email" type="email" class="form-control border-2 shadow-none"
                                    value="{{ old('email', $user->email) }}" required />
                                <x-input-error class="text-danger small mt-1" :messages="$errors->get('email')" />
                            </div>

                            <div class="mb-4">
                                <label for="role"
                                    class="form-label fw-bold text-dark small">{{ __('Assign Role') }}</label>
                                <select id="role" name="role" class="form-select border-2 shadow-none" required>
                                    <option value="voter" {{ old('role', $user->role) === 'voter' ? 'selected' : '' }}>
                                        Voter</option>
                                    <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>
                                        Administrator</option>
                                </select>
                                <x-input-error class="text-danger small mt-1" :messages="$errors->get('role')" />
                            </div>

                            <hr class="my-5 opacity-25">

                            <div class="mb-4">
                                <h5 class="fw-bold text-dark mb-3">Update Password <small
                                        class="text-muted font-normal">(Optional)</small></h5>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="password"
                                            class="form-label fw-bold text-dark small">{{ __('New Password') }}</label>
                                        <input id="password" name="password" type="password"
                                            class="form-control border-2 shadow-none" />
                                        <x-input-error class="text-danger small mt-1"
                                            :messages="$errors->get('password')" />
                                    </div>
                                    <div class="col-md-6">
                                        <label for="password_confirmation"
                                            class="form-label fw-bold text-dark small">{{ __('Confirm Password') }}</label>
                                        <input id="password_confirmation" name="password_confirmation" type="password"
                                            class="form-control border-2 shadow-none" />
                                    </div>
                                </div>
                            </div>

                            <div class="d-grid mt-5">
                                <button type="submit" class="btn btn-theme rounded-pill py-2 fw-bold shadow-sm">
                                    Save User Changes
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>