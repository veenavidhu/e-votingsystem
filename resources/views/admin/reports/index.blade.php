<x-app-layout>
    <x-slot name="header">
        {{ __('Voting Reports & Analytics') }}
    </x-slot>

    <div class="container-fluid py-4">
        <!-- Overview Cards -->
        <div class="row g-4 mb-4">
            <div class="col-md-3">
                <div class="card border-0 rounded-4 shadow-sm p-4 h-100">
                    <h6 class="text-muted text-uppercase fw-bold small mb-2">Total Voters</h6>
                    <div class="h2 fw-bold mb-0">{{ $totalUsers }}</div>
                    <div class="progress mt-3 rounded-pill" style="height: 6px;">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: 100%"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 rounded-4 shadow-sm p-4 h-100">
                    <h6 class="text-muted text-uppercase fw-bold small mb-2">Votes Cast</h6>
                    <div class="h2 fw-bold text-success mb-0">{{ $votedUsers }}</div>
                    <div class="progress mt-3 rounded-pill" style="height: 6px;">
                        <div class="progress-bar bg-success" role="progressbar" style="width: {{ $votedPercentage }}%">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 rounded-4 shadow-sm p-4 h-100">
                    <h6 class="text-muted text-uppercase fw-bold small mb-2">Pending Votes</h6>
                    <div class="h2 fw-bold text-warning mb-0">{{ $pendingUsers }}</div>
                    <div class="progress mt-3 rounded-pill" style="height: 6px;">
                        <div class="progress-bar bg-warning" role="progressbar"
                            style="width: {{ 100 - $votedPercentage }}%"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 rounded-4 shadow-sm p-4 h-100">
                    <h6 class="text-muted text-uppercase fw-bold small mb-2">Turnout Rate</h6>
                    <div class="h2 fw-bold text-info mb-0">{{ number_format($votedPercentage, 1) }}%</div>
                    <div class="progress mt-3 rounded-pill" style="height: 6px;">
                        <div class="progress-bar bg-info" role="progressbar" style="width: {{ $votedPercentage }}%">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <!-- Candidate Summary -->
            <div class="col-lg-5">
                <div class="card border-0 rounded-4 shadow-sm h-100">
                    <div class="card-header bg-white border-0 py-4 px-4">
                        <h5 class="fw-bold mb-0">Candidate Statistics</h5>
                    </div>
                    <div class="card-body px-4 pt-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="text-muted small">
                                    <tr>
                                        <th>Candidate</th>
                                        <th class="text-center">Votes</th>
                                        <th class="text-end">Percentage</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($candidateStats as $stat)
                                        @php $pct = $votedUsers > 0 ? ($stat->votes_count / $votedUsers) * 100 : 0; @endphp
                                        <tr>
                                            <td>
                                                <div class="fw-bold text-dark">{{ $stat->name }}</div>
                                                <div class="small text-muted">{{ $stat->party }}</div>
                                            </td>
                                            <td class="text-center fw-bold">{{ $stat->votes_count }}</td>
                                            <td class="text-end">
                                                <span
                                                    class="badge bg-light text-dark rounded-pill">{{ number_format($pct, 1) }}%</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Voting Activity -->
            <div class="col-lg-7">
                <div class="card border-0 rounded-4 shadow-sm h-100">
                    <div
                        class="card-header bg-white border-0 py-4 px-4 d-flex justify-content-between align-items-center">
                        <h5 class="fw-bold mb-0">Recent Voting Logs</h5>
                        <button onclick="window.print()" class="btn btn-sm btn-theme rounded-pill px-3">
                            <i class="bi bi-printer me-1"></i> Print Report
                        </button>
                    </div>
                    <div class="card-body px-4 pt-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle" id="reportsTable">
                                <thead class="text-muted small">
                                    <tr>
                                        <th>Voter</th>
                                        <th>Casted For</th>
                                        <th class="text-end">Timestamp</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($votes as $vote)
                                        <tr>
                                            <td>
                                                <div class="fw-bold text-dark">{{ $vote->user->name }}</div>
                                                <div class="small text-muted">{{ $vote->user->email }}</div>
                                            </td>
                                            <td>
                                                <span
                                                    class="badge bg-primary bg-opacity-10 text-primary px-3 rounded-pill">{{ $vote->candidate->name }}</span>
                                            </td>
                                            <td class="text-end text-muted small">
                                                {{ $vote->created_at->format('M d, H:i') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">
                            {{ $votes->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $('#reportsTable').DataTable({
                "paging": false,
                "info": false,
                "searching": true,
                "order": [[2, "desc"]],
                "language": {
                    "search": "Filter Activity:"
                }
            });
        });
    </script>
</x-app-layout>