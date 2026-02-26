<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 text-white font-bold mb-0">
            {{ __('Election Results Dashboard') }}
        </h2>
    </x-slot>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-11">
                <div class="card shadow border-0 rounded-4 p-4 p-md-5">
                    <h3 class="h4 font-bold mb-5 text-center text-primary text-uppercase letter-spacing-1">Live Election Tracking</h3>

                    <div class="row g-5 align-items-center">
                        <!-- Progress Bars -->
                        <div class="col-lg-7">
                            <div class="space-y-4">
                                @php $totalVotes = $candidates->sum('votes_count'); @endphp
                                @foreach($candidates as $candidate)
                                    @php 
                                        $percentage = $totalVotes > 0 ? ($candidate->votes_count / $totalVotes) * 100 : 0;
                                    @endphp
                                    <div class="mb-4">
                                        <div class="d-flex justify-content-between mb-2">
                                            <div class="d-flex align-items-center">
                                                <div class="rounded-circle overflow-hidden bg-light me-3 d-flex align-items-center justify-content-center border" style="width: 50px; height: 50px;">
                                                    @if($candidate->photo_path)
                                                        <img src="{{ str_contains($candidate->photo_path, 'http') ? $candidate->photo_path : asset('storage/' . $candidate->photo_path) }}" 
                                                             alt="{{ $candidate->name }}" class="w-100 h-100 object-fit-cover">
                                                    @else
                                                        <span class="text-muted fw-bold">{{ substr($candidate->name, 0, 1) }}</span>
                                                    @endif
                                                </div>
                                                <div>
                                                    <span class="h6 font-bold d-block mb-0">{{ $candidate->name }}</span>
                                                    <small class="text-muted">{{ $candidate->party }}</small>
                                                </div>
                                            </div>
                                            <div class="text-end">
                                                <span class="badge bg-primary rounded-pill px-3">{{ $candidate->votes_count }} Votes</span>
                                            </div>
                                        </div>
                                        <div class="progress rounded-pill shadow-sm" style="height: 12px;">
                                            <div class="progress-bar bg-primary" role="progressbar" style="width: {{ $percentage }}%" aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <div class="text-end mt-1 small font-bold text-primary">{{ number_format($percentage, 1) }}%</div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Stats Grid -->
                        <div class="col-lg-5">
                            <div class="row g-3">
                                <div class="col-6">
                                    <div class="card bg-light border-0 rounded-4 p-4 text-center h-100 shadow-sm">
                                        <p class="text-muted small uppercase fw-bold mb-1">Total Turnout</p>
                                        <span class="display-6 font-bold text-dark">{{ $totalVotes }}</span>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="card bg-light border-0 rounded-4 p-4 text-center h-100 shadow-sm">
                                        <p class="text-muted small uppercase fw-bold mb-1">Candidates</p>
                                        <span class="display-6 font-bold text-dark">{{ $candidates->count() }}</span>
                                    </div>
                                </div>
                                <div class="col-12 mt-3">
                                    <div class="card bg-primary text-white border-0 rounded-4 p-4 text-center shadow">
                                        <p class="text-white text-opacity-75 small uppercase fw-bold mb-1">Leading Candidate</p>
                                        <span class="h3 font-bold mb-0">
                                            @if($totalVotes > 0)
                                                <i class="bi bi-trophy-fill me-2"></i>
                                                @if($frontrunners->count() > 1)
                                                    <span title="{{ $frontrunners->pluck('name')->join(', ') }}">Tie: {{ $frontrunners->count() }} Candidates</span>
                                                @else
                                                    {{ $frontrunners->first()->name }}
                                                @endif
                                            @else
                                                <span class="text-white text-opacity-50">No votes yet</span>
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
