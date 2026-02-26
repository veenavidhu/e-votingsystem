<x-app-layout>
    <x-slot name="header">
        {{ __('User Management') }}
    </x-slot>

    <div class="container-fluid py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold text-dark mb-0">System Users</h3>
                <p class="text-muted small mb-0">Manage roles and permissions for all users</p>
            </div>
            <div class="d-flex gap-2">
                <button type="button" class="btn btn-theme-outline rounded-pill px-4 fw-bold shadow-sm"
                    data-bs-toggle="modal" data-bs-target="#bulkImportModal">
                    <i class="bi bi-file-earmark-arrow-up me-2"></i>Bulk Import
                </button>
                <a href="{{ route('admin.users.create') }}" class="btn btn-theme rounded-pill px-4 fw-bold shadow-sm">
                    <i class="bi bi-person-plus me-2"></i>Add New User
                </a>
            </div>
        </div>

    </div>

    <div class="card border-0 rounded-4 shadow-sm p-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0" id="usersTable">
                <thead class="bg-light">
                    <tr>
                        <th class="px-4 py-3 border-0">User</th>
                        <th class="py-3 border-0">Role</th>
                        <th class="py-3 border-0 text-center">Voting Status</th>
                        <th class="py-3 border-0">Joined</th>
                        <th class="px-4 py-3 border-0 text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td class="px-4 py-3">
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center me-3"
                                        style="width: 40px; height: 40px;">
                                        <span
                                            class="fw-bold text-primary">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark mb-0">{{ $user->name }}</div>
                                        <div class="text-muted small">{{ $user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if($user->role === 'admin')
                                    <span
                                        class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-3">Administrator</span>
                                @else
                                    <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3">Voter</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($user->has_voted)
                                    <i class="bi bi-check-circle-fill text-success fs-5" title="Voted"></i>
                                @else
                                    <i class="bi bi-clock-history text-muted fs-5" title="Pending"></i>
                                @endif
                            </td>
                            <td>
                                <span class="text-muted small">{{ $user->created_at->format('M d, Y') }}</span>
                            </td>
                            <td class="px-4 text-end">
                                <div class="d-flex justify-content-end align-items-center">
                                    @if($user->id !== Auth::id())
                                        <a href="{{ route('admin.users.login-as', $user) }}"
                                            class="btn btn-sm btn-outline-info rounded-circle me-2 shadow-sm"
                                            title="Autologin as {{ $user->name }}">
                                            <i class="bi bi-box-arrow-in-right"></i>
                                        </a>
                                    @endif
                                    <div class="dropdown">
                                        <button class="btn btn-light btn-sm rounded-circle shadow-none" type="button"
                                            data-bs-toggle="dropdown">
                                            <i class="bi bi-three-dots-vertical"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg rounded-3">
                                            <li><a class="dropdown-item" href="{{ route('admin.users.edit', $user) }}"><i
                                                        class="bi bi-pencil me-2"></i>Edit</a></li>
                                            @if($user->id !== Auth::id())
                                                <li>
                                                    <hr class="dropdown-divider">
                                                </li>
                                                <li>
                                                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}"
                                                        onsubmit="return confirm('Are you sure you want to delete this user?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="dropdown-item text-danger"><i
                                                                class="bi bi-trash me-2"></i>Delete</button>
                                                    </form>
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    </div>

    <!-- Bulk Import Modal -->
    <div class="modal fade" id="bulkImportModal" tabindex="-1" aria-labelledby="bulkImportModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form action="{{ route('admin.users.import') }}" method="POST" enctype="multipart/form-data"
                class="modal-content border-0 shadow rounded-4">
                @csrf
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold" id="bulkImportModalLabel">Bulk User Import</h5>
                    <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body py-4">
                    <p class="text-secondary small mb-4">
                        Upload a CSV file containing user details. Please ensure the file follows our standard template.
                    </p>

                    <div class="mb-4">
                        <label for="file" class="form-label fw-bold text-dark small mb-2">Select CSV File</label>
                        <input class="form-control border-2 shadow-none" type="file" id="file" name="file" accept=".csv"
                            required>
                    </div>

                    <div class="alert alert-info border-0 rounded-4 py-3 mb-0">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-info-circle-fill fs-4 me-3"></i>
                            <div>
                                <h6 class="fw-bold mb-1 small">Need a template?</h6>
                                <p class="mb-0 x-small">Download our sample CSV to ensure correct formatting.</p>
                                <a href="{{ route('admin.users.download-template') }}"
                                    class="btn btn-link p-0 mt-1 x-small fw-bold text-decoration-none">
                                    <i class="bi bi-download me-1"></i>Download CSV Template
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light rounded-pill px-4"
                        data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-theme rounded-pill px-4 fw-bold">
                        Start Import
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            // Initialize DataTable
            $('#usersTable').DataTable({
                "pageLength": 10,
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                "order": [[3, "desc"]], // Sort by Joined date
                "columnDefs": [
                    { "orderable": false, "targets": [4] } // Disable sorting on Actions
                ],
                "language": {
                    "search": "Filter users:",
                    "paginate": {
                        "previous": "<i class='bi bi-chevron-left'></i>",
                        "next": "<i class='bi bi-chevron-right'></i>"
                    }
                }
            });
        });
    </script>
</x-app-layout>