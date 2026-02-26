<x-app-layout>
    <x-slot name="header">
        {{ __('Account Settings') }}
    </x-slot>

    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="card border-0 rounded-4 shadow-sm mb-4">
                    <div class="card-body p-4 p-md-5">
                        <div class="max-w-xl">
                            @include('profile.partials.update-profile-information-form')
                        </div>
                    </div>
                </div>

                <div class="card border-0 rounded-4 shadow-sm mb-4">
                    <div class="card-body p-4 p-md-5">
                        <div class="max-w-xl">
                            @include('profile.partials.update-password-form')
                        </div>
                    </div>
                </div>

                <div class="card border-0 rounded-4 shadow-sm border-start border-danger border-5">
                    <div class="card-body p-4 p-md-5">
                        <div class="max-w-xl">
                            @include('profile.partials.delete-user-form')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>