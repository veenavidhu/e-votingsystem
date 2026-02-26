<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 text-white font-bold mb-0">
            {{ __('Add New Candidate') }}
        </h2>
    </x-slot>

    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4 p-md-5">
                        <form action="{{ route('admin.candidates.store') }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf

                            <div class="text-center mb-5">
                                <div class="position-relative d-inline-block">
                                    <div class="rounded-circle overflow-hidden bg-light border border-4 border-white shadow-sm"
                                        style="width: 150px; height: 150px;">
                                        <img id="imagePreview" src="https://via.placeholder.com/150?text=Upload"
                                            class="w-100 h-100 object-fit-cover">
                                    </div>
                                    <label for="photoUpload"
                                        class="position-absolute bottom-0 end-0 btn btn-theme btn-sm rounded-circle p-2 shadow">
                                        <i class="bi bi-camera-fill"></i>
                                    </label>
                                    <input type="file" name="photo" id="photoUpload" class="d-none" accept="image/*"
                                        onchange="previewImage(this)">
                                </div>
                                <div class="mt-2 fw-bold text-muted small">Candidate Profile Photo</div>
                                @error('photo') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold text-dark">Full Name</label>
                                <input type="text" name="name"
                                    class="form-control form-control-lg rounded-3 shadow-none border-2"
                                    placeholder="e.g. John Doe" required>
                                @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold text-dark">Political Party</label>
                                <input type="text" name="party"
                                    class="form-control form-control-lg rounded-3 shadow-none border-2"
                                    placeholder="e.g. Progressive Alliance" required>
                                @error('party') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold text-dark">Vision / Description</label>
                                <textarea name="description" rows="4"
                                    class="form-control rounded-3 shadow-none border-2"
                                    placeholder="Describe the candidate's vision or key policies..."></textarea>
                                @error('description') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-5">
                                <a href="{{ route('admin.candidates.index') }}"
                                    class="btn btn-theme-outline btn-lg rounded-pill px-5 fw-bold text-muted">Cancel</a>
                                <button type="submit"
                                    class="btn btn-theme btn-lg rounded-pill px-5 fw-bold shadow-sm">Save
                                    Candidate</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function previewImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    document.getElementById('imagePreview').src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</x-app-layout>