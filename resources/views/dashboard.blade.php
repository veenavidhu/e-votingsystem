{{-- Primary Application Layout: Contains Sidebar, Navigation and Content Area --}}
<x-app-layout>
    <x-slot name="header">
        {{ __('Visionary Dashboard') }}
    </x-slot>

    <div class="container-fluid pb-5">
        <!-- Hero Section -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 rounded-4 overflow-hidden shadow-sm position-relative" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); min-height: 180px;">
                    <div class="card-body p-4 d-flex flex-column justify-content-center text-white position-relative z-1">
                        <div class="row align-items-center">
                            <div class="col-lg-12">
                                <div class="badge bg-success bg-opacity-25 rounded-pill px-3 py-1 mb-3 fw-bold text-uppercase small shadow-none border border-white border-opacity-25"><i class="bi bi-patch-check-fill me-1"></i> System Operational</div>
                                <h2 class="fw-bold mb-2">Welcome, {{ Auth::user()->name }}!</h2>
                                <p class="mb-0 opacity-75">Democracy in action. Explore live voting analytics and trends below.</p>
                                @if(Auth::user()->role === 'voter' && !Auth::user()->has_voted)
                                    <div class="mt-3">
                                        <a href="{{ route('voting.index') }}" class="btn btn-white btn-sm rounded-pill px-4 fw-bold shadow-sm">
                                            Cast Vote Now <i class="bi bi-arrow-right ms-1"></i>
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4 mb-5">
            <!-- Stats Grid -->
            @if(Auth::user()->role === 'admin')
                <div class="col-md-4">
                    <div class="card border-0 rounded-4 shadow-sm h-100 p-4 border-start border-primary border-5">
                        <div class="d-flex align-items-center mb-3">
                            <div class="rounded-circle bg-primary bg-opacity-10 p-3 me-3 text-primary">
                                <i class="bi bi-people-fill fs-4"></i>
                            </div>
                            <h6 class="mb-0 fw-bold text-uppercase tracking-wide text-muted">Total Participation</h6>
                        </div>
                        <div class="display-5 fw-bold text-dark mb-1">{{ $totalVotes }}</div>
                        <p class="text-muted small mb-0"><i class="bi bi-arrow-up text-success me-1"></i> Live Vote Count</p>
                    </div>
                </div>
            @endif

            <div class="{{ Auth::user()->role === 'admin' ? 'col-md-4' : 'col-md-6' }}">
                <div class="card border-0 rounded-4 shadow-sm h-100 p-4 border-start border-success border-5">
                    @if(Auth::user()->role === 'admin')
                        <!-- Admin View: Global Participation -->
                        <div class="d-flex align-items-center mb-3">
                            <div class="rounded-circle bg-success bg-opacity-10 p-3 me-3 text-success">
                                <i class="bi bi-graph-up-arrow fs-4"></i>
                            </div>
                            <h6 class="mb-0 fw-bold text-uppercase tracking-wide text-muted">Global Participation</h6>
                        </div>
                        <div class="display-6 fw-bold text-dark mb-1">{{ $turnoutPercentage }}%</div>
                        <p class="text-muted small mb-0">From {{ $totalVoters }} registered voters</p>
                    @else
                        <!-- Voter View: Personal Status -->
                        <div class="d-flex align-items-center mb-3">
                            <div class="rounded-circle bg-success bg-opacity-10 p-3 me-3 text-success">
                                <i class="bi bi-file-earmark-check fs-4"></i>
                            </div>
                            <h6 class="mb-0 fw-bold text-uppercase tracking-wide text-muted">Your Voting Status</h6>
                        </div>
                        <div class="h2 fw-bold mb-1 mt-2">
                            @if(Auth::user()->has_voted)
                                <span class="text-success"><i class="bi bi-check-circle-fill me-2"></i>Completed</span>
                            @else
                                <span class="text-warning"><i class="bi bi-hourglass-split me-2"></i>Pending</span>
                            @endif
                        </div>
                        <p class="text-muted small mb-0">Your participation matters</p>
                    @endif
                </div>
            </div>

            <div class="{{ Auth::user()->role === 'admin' ? 'col-md-4' : 'col-md-6' }}">
                <div class="card border-0 rounded-4 shadow-sm h-100 p-4 border-start border-info border-5" style="background: rgba(102, 126, 234, 0.05);">
                    <div class="d-flex align-items-center mb-3">
                        <div class="rounded-circle bg-info bg-opacity-10 p-3 me-3 text-info">
                            <i class="bi bi-trophy fs-4"></i>
                        </div>
                        <h6 class="mb-0 fw-bold text-uppercase tracking-wide text-muted">Current Frontrunner</h6>
                    </div>
                    <div class="h3 fw-bold text-dark mb-1 text-truncate">
                        @if($totalVotes > 0)
                            @if($frontrunners->count() > 1)
                                <span title="{{ $frontrunners->pluck('name')->join(', ') }}">Tie: {{ $frontrunners->count() }} Candidates</span>
                            @else
                                {{ $frontrunners->first()->name }}
                            @endif
                        @else
                            Awaiting Data
                        @endif
                    </div>
                    <p class="text-info opacity-75 small mb-0 fw-bold">Live Leaderboard Position</p>
                </div>
            </div>
        </div>

        @if(Auth::user()->role === 'admin')
            <div class="row g-4">
                <!-- Analytics Chart -->
                <div class="col-lg-7">
                    <div class="card border-0 rounded-4 shadow-sm p-4 h-100">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="fw-bold mb-0">Voting Distribution Overview</h5>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-white border ripple" type="button"><i class="bi bi-download"></i></button>
                            </div>
                        </div>
                        <div style="height: 350px;">
                            <canvas id="votingChart"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Live Rates Progress -->
                <div class="col-lg-5">
                    <div class="card border-0 rounded-4 shadow-sm p-4 h-100">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="fw-bold mb-0">Live Candidate Standing</h5>
                            <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-3 py-1"><span class="spinner-grow spinner-grow-sm me-1"></span> Live Data</span>
                        </div>
                        <div class="overflow-auto custom-scrollbar pe-2" style="max-height: 400px;">
                                    @foreach($candidates->sortByDesc('votes_count') as $candidate)
                                    @php 
                                        $percentage = $totalVotes > 0 ? ($candidate->votes_count / $totalVotes) * 100 : 0;
                                    @endphp
                                    <div class="mb-4">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <div class="d-flex align-items-center">
                                                <div class="rounded-circle overflow-hidden bg-light me-3 d-flex align-items-center justify-content-center border" style="width: 45px; height: 45px;">
                                                    @if($candidate->photo_path)
                                                        <img src="{{ str_contains($candidate->photo_path, 'http') ? $candidate->photo_path : asset('storage/' . $candidate->photo_path) }}" 
                                                             alt="{{ $candidate->name }}" class="w-100 h-100 object-fit-cover">
                                                    @else
                                                        <span class="text-muted small fw-bold">{{ substr($candidate->name, 0, 1) }}</span>
                                                    @endif
                                                </div>
                                                <div>
                                                    <div class="fw-bold text-dark mb-0">{{ $candidate->name }}</div>
                                                    <small class="text-muted">{{ $candidate->party }}</small>
                                                </div>
                                            </div>
                                            <div class="text-end">
                                                <span class="badge bg-primary rounded-pill mb-1">{{ number_format($percentage, 0) }}%</span>
                                            </div>
                                        </div>
                                        <div class="progress rounded-pill shadow-none" style="height: 10px; background: #e9ecef;">
                                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary" role="progressbar" style="width: {{ $percentage }}%" aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @else
            <!-- Simplified Voter Dashboard: Only show frontrunner details if they exist -->
            @if($totalVotes > 0)
                <div class="row g-4 mt-2">
                    <div class="col-12">
                        <div class="card border-0 rounded-4 shadow-sm p-4">
                            <h5 class="fw-bold mb-4">Current Leading Talent</h5>
                            <div class="row">
                                @foreach($frontrunners as $frontrunner)
                                    <div class="col-md-4 mb-3">
                                        <div class="d-flex align-items-center p-3 rounded-4 bg-light border border-primary border-opacity-10 border-2">
                                            <div class="rounded-circle overflow-hidden bg-primary bg-opacity-10 me-3 d-flex align-items-center justify-content-center shadow-sm" style="width: 60px; height: 60px;">
                                                @if($frontrunner->photo_path)
                                                    <img src="{{ str_contains($frontrunner->photo_path, 'http') ? $frontrunner->photo_path : asset('storage/' . $frontrunner->photo_path) }}" 
                                                         alt="{{ $frontrunner->name }}" class="w-100 h-100 object-fit-cover">
                                                @else
                                                    <span class="fw-bold text-primary">{{ substr($frontrunner->name, 0, 1) }}</span>
                                                @endif
                                            </div>
                                            <div>
                                                <div class="fw-bold text-dark">{{ $frontrunner->name }}</div>
                                                <small class="text-muted">{{ $frontrunner->party }}</small>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endif
    </div>
    @if(Auth::user()->role === 'admin')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const ctx = document.getElementById('votingChart').getContext('2d');
                const candidates = {!! json_encode($candidates->pluck('name')) !!};
                const votes = {!! json_encode($candidates->pluck('votes_count')) !!};

                new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: candidates,
                        datasets: [{
                            label: 'Votes Cast',
                            data: votes,
                            backgroundColor: 'rgba(118, 75, 162, 0.7)',
                            borderColor: 'rgba(118, 75, 162, 1)',
                            borderWidth: 2,
                            borderRadius: 8,
                            barThickness: 35,
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                backgroundColor: '#fff',
                                titleColor: '#000',
                                bodyColor: '#333',
                                borderColor: '#ddd',
                                borderWidth: 1,
                                padding: 12,
                                displayColors: false
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                grid: { color: 'rgba(0,0,0,0.05)', drawBorder: false },
                                ticks: { font: { size: 12 } }
                            },
                            x: {
                                grid: { display: false },
                                ticks: { font: { weight: 'bold', size: 12 } }
                            }
                        }
                    }
                });
            });

            // Live Data Simulation
            setInterval(() => {
                const badges = document.querySelectorAll('.badge.bg-danger');
                badges.forEach(badge => {
                    badge.style.opacity = '0.5';
                    setTimeout(() => badge.style.opacity = '1', 500);
                });
            }, 3000);
        </script>
    @endif

    <style>
        .hover-up:hover { transform: translateY(-3px); transition: 0.3s; }
        .custom-scrollbar::-webkit-scrollbar { width: 5px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #dee2e6; border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #ced4da; }
    </style>
</x-app-layout>