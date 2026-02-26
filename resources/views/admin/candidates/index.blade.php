{{-- Admin Candidate Management: Lists candidates with DataTables integration and action buttons --}}
<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 text-white font-bold mb-0">
                {{ __('Candidate Management') }}
            </h2>
            <a href="{{ route('admin.candidates.create') }}" class="btn btn-white btn-sm rounded-pill px-4 fw-bold">
                <i class="bi bi-plus-circle me-1"></i> Add Candidate
            </a>
        </div>
    </x-slot>

    <div class="container-fluid py-4">
        @if(session('success'))
            <script>toastr.success("{{ session('success') }}");</script>
        @endif

        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-header bg-white py-4 border-light">
                <div class="row align-items-center">
                    <div class="col">
                        <h5 class="fw-bold text-dark mb-0">Registered Candidates</h5>
                        <p class="text-muted small mb-0">Manage election contenders and their profiles</p>
                    </div>
                    <div class="col-auto">
                        <a href="{{ route('admin.candidates.create') }}" class="btn btn-theme rounded-pill px-4 fw-bold">
                            <i class="bi bi-plus-lg me-2"></i> Add New Candidate
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" id="candidatesTable">
                        <thead class="bg-light text-muted small text-uppercase">
                            <tr>
                                <th class="ps-4 py-3">Candidate Info</th>
                                <th class="py-3">Party Affiliation</th>
                                <th class="py-3" style="width: 250px;">Voting Progress</th>
                                <th class="py-3">Vision Statement</th>
                                <th class="text-end pe-4 py-3">Management</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($candidates as $candidate)
                                <tr class="transition-all hover-row">
                                    <td class="ps-4">
                                        <div class="d-flex align-items-center py-2">
                                            <div class="avatar-container me-3 position-relative">
                                                <div class="rounded-circle overflow-hidden bg-light border border-2 border-white shadow-sm" style="width: 60px; height: 60px;">
                                                    @if($candidate->photo_path)
                                                        <img src="{{ str_contains($candidate->photo_path, 'http') ? $candidate->photo_path : asset('storage/' . $candidate->photo_path) }}" 
                                                             class="w-100 h-100 object-fit-cover current-photo">
                                                    @else
                                                        <div class="w-100 h-100 d-flex align-items-center justify-content-center text-primary fw-bold fs-4">
                                                            {{ substr($candidate->name, 0, 1) }}
                                                        </div>
                                                    @endif
                                                </div>
                                                <form action="{{ route('admin.candidates.update', $candidate) }}" method="POST" enctype="multipart/form-data" class="quick-upload-form">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="file" name="photo" class="d-none photo-input" accept="image/*" onchange="this.form.submit()">
                                                    <label class="avatar-edit-overlay rounded-circle d-flex align-items-center justify-content-center cursor-pointer" onclick="$(this).prev().click()">
                                                        <i class="bi bi-camera-fill text-white fs-5"></i>
                                                    </label>
                                                    <!-- Hide other fields so they aren't wiped on direct photo upload -->
                                                    <input type="hidden" name="name" value="{{ $candidate->name }}">
                                                    <input type="hidden" name="party" value="{{ $candidate->party }}">
                                                </form>
                                            </div>
                                            <div>
                                                <div class="fw-bold text-dark fs-6">{{ $candidate->name }}</div>
                                                <small class="text-muted">ID: #{{ $candidate->id }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-10 rounded-pill px-3 py-2 fw-semibold">
                                            <i class="bi bi-flag-fill me-1"></i> {{ $candidate->party }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <span class="small fw-bold text-muted">{{ $candidate->votes_count }} Votes</span>
                                            @php 
                                                $totalVotesOverall = \App\Models\Vote::count();
                                                $pctGlobal = $totalVotesOverall > 0 ? round(($candidate->votes_count / $totalVotesOverall) * 100, 1) : 0;
                                            @endphp
                                            <span class="small fw-bold text-primary">{{ $pctGlobal }}%</span>
                                        </div>
                                        <div class="progress rounded-pill bg-light shadow-none" style="height: 6px;">
                                            <div class="progress-bar bg-primary shadow-sm" style="width: {{ $pctGlobal }}%"></div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-muted small text-truncate-2 italic" style="max-width: 300px;">
                                            {{ $candidate->description ?: 'No vision statement provided.' }}
                                        </div>
                                    </td>
                                    <td class="text-end pe-4">
                                        <div class="btn-group shadow-sm rounded-pill overflow-hidden bg-white border">
                                            <a href="{{ route('admin.candidates.edit', $candidate) }}" class="btn btn-white btn-sm px-3 hover-text-primary" title="Edit Profile">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                            <form action="{{ route('admin.candidates.destroy', $candidate) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-white btn-sm px-3 hover-text-danger" title="Delete Candidate" onclick="return confirm('Archive this candidate? All associated votes will be lost.')">
                                                    <i class="bi bi-trash-fill"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <style>
        .hover-row:hover { background-color: rgba(var(--bs-primary-rgb), 0.02) !important; }
        .text-truncate-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
        .italic { font-style: italic; }
        .transition-all { transition: all 0.2s ease; }
        .cursor-pointer { cursor: pointer; }
        
        .avatar-container {
            cursor: pointer;
        }
        
        .avatar-edit-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 60px;
            height: 60px;
            background: rgba(0, 0, 0, 0.4);
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        
        .avatar-container:hover .avatar-edit-overlay {
            opacity: 1;
        }
        
        .hover-text-primary:hover { color: var(--bs-primary) !important; background: rgba(var(--bs-primary-rgb), 0.05); }
        .hover-text-danger:hover { color: var(--bs-danger) !important; background: rgba(var(--bs-danger-rgb), 0.05); }
    </style>

    <script>
        $(document).ready(function() {
            $('#candidatesTable').DataTable({
                "pageLength": 10,
                "language": {
                    "search": "Filter candidates:",
                    "paginate": {
                        "previous": "<i class='bi bi-chevron-left'></i>",
                        "next": "<i class='bi bi-chevron-right'></i>"
                    }
                },
                "columnDefs": [
                    { "orderable": false, "targets": [0, 4] }
                ]
            });
        });
    </script>
</x-app-layout>