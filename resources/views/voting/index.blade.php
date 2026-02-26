<x-app-layout>
    <x-slot name="header">
        {{ __('Secure Voting Booth') }}
    </x-slot>

    <div class="container-fluid pb-5">
        <!-- Hero Section -->
        <div class="row mb-5">
            <div class="col-12">
                <div class="card border-0 rounded-5 overflow-hidden shadow-lg position-relative"
                    style="background: linear-gradient(135deg, #764ba2 0%, #667eea 100%); min-height: 220px;">
                    <div
                        class="card-body p-4 p-md-5 d-flex flex-column justify-content-center text-white position-relative z-1">
                        <div class="row align-items-center">
                            <div class="col-lg-8">
                                <div
                                    class="badge bg-info rounded-pill px-3 py-1 mb-3 fw-bold text-uppercase tracking-wider shadow-sm">
                                    <i class="bi bi-shield-fill-check me-1"></i> Confidential Session
                                </div>
                                <h1 class="display-5 fw-bold mb-2">Select Your Representative</h1>
                                <p class="lead mb-0 opacity-75">Your vote is private, secure, and encrypted. Review the
                                    candidates below and cast your selection with confidence.</p>
                            </div>
                            <div class="col-lg-4 d-none d-lg-block text-end opacity-25">
                                <i class="bi bi-shield-lock-fill" style="font-size: 8rem;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <form id="votingForm" action="{{ route('voting.store') }}" method="POST">
            @csrf
            <div class="row g-4">
                @foreach($candidates as $candidate)
                    <div class="col-xl-3 col-lg-4 col-md-6">
                        <input type="radio" name="candidate_id" id="candidate_{{ $candidate->id }}"
                            value="{{ $candidate->id }}" class="btn-check" required>
                        <label for="candidate_{{ $candidate->id }}" class="candidate-card h-100 w-100 cursor-pointer">
                            <div
                                class="card border-0 rounded-4 shadow-sm h-100 overflow-hidden text-center transition-all duration-300">
                                <div class="card-body p-4 pt-5">
                                    <div
                                        class="candidate-avatar mx-auto mb-4 d-flex align-items-center justify-content-center overflow-hidden rounded-circle bg-light border border-2 border-white shadow-sm">
                                        @if($candidate->photo_path)
                                            <img src="{{ str_contains($candidate->photo_path, 'http') ? $candidate->photo_path : asset('storage/' . $candidate->photo_path) }}"
                                                alt="{{ $candidate->name }}" class="w-100 h-100 object-fit-cover">
                                        @else
                                            <div class="avatar-ring"></div>
                                            <span class="initials">{{ substr($candidate->name, 0, 1) }}</span>
                                        @endif
                                    </div>
                                    <h4 class="fw-bold text-dark mb-1">{{ $candidate->name }}</h4>
                                    <div class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-3 mb-3 fw-bold">
                                        {{ $candidate->party }}
                                    </div>
                                    <p class="text-muted small mb-0 px-2 line-clamp-3 italic">
                                        "{{ $candidate->description }}"
                                    </p>
                                </div>
                                <div class="card-footer bg-light border-0 py-3 selection-indicator">
                                    <span class="text-muted fw-bold small"><i class="bi bi-circle me-2"></i>Click to
                                        Select</span>
                                </div>
                            </div>
                        </label>
                    </div>
                @endforeach
            </div>

            <div class="mt-5 text-center">
                <button type="button" id="submitBtn"
                    class="btn btn-theme btn-lg rounded-pill px-5 py-3 shadow-lg fw-bold text-uppercase tracking-wider hover-up">
                    <i class="bi bi-send-check-fill me-2"></i>Cast My Official Vote
                </button>
            </div>

            <!-- Confirmation Modal -->
            <div class="modal fade" id="confirmVoteModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content border-0 rounded-4 shadow-lg">
                        <div class="modal-body p-5 text-center">
                            <div class="rounded-circle bg-warning bg-opacity-10 text-warning d-inline-flex align-items-center justify-content-center mb-4"
                                style="width: 80px; height: 80px;">
                                <i class="bi bi-exclamation-triangle-fill fs-1"></i>
                            </div>
                            <h3 class="fw-bold mb-3">Confirm Your Choice</h3>
                            <p class="text-muted mb-4 fs-5">You are about to vote for <span id="selectedCandidateName"
                                    class="fw-bold text-dark"></span>. This action <span
                                    class="text-danger fw-bold underline">cannot be undone</span>.</p>
                            <div class="d-grid gap-3">
                                <button type="submit" class="btn btn-theme btn-lg rounded-pill py-3 fw-bold">YES,
                                    CONFIRM MY VOTE</button>
                                <button type="button" class="btn btn-light btn-lg rounded-pill py-3 fw-bold"
                                    data-bs-dismiss="modal">GO BACK</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <style>
        .candidate-card .card {
            border: 2px solid transparent !important;
        }

        .candidate-card:hover .card {
            transform: translateY(-8px);
            border-color: rgba(118, 75, 162, 0.2) !important;
            box-shadow: 0 1rem 3rem rgba(0, 0, 0, .1) !important;
        }

        .btn-check:checked+.candidate-card .card {
            border-color: #764ba2 !important;
            background-color: rgba(118, 75, 162, 0.02);
        }

        .btn-check:checked+.candidate-card .selection-indicator {
            background: #764ba2 !important;
            color: white !important;
        }

        .btn-check:checked+.candidate-card .selection-indicator span {
            color: white !important;
        }

        .btn-check:checked+.candidate-card .selection-indicator i::before {
            content: "\F26C";
            color: white;
        }

        /* bi-check-circle-fill */

        .candidate-avatar {
            width: 100px;
            height: 100px;
            position: relative;
        }

        .avatar-ring {
            position: absolute;
            inset: -5px;
            border: 3px solid rgba(118, 75, 162, 0.1);
            border-radius: 50%;
            transition: 0.3s;
        }

        .candidate-card:hover .avatar-ring {
            border-color: #764ba2;
            border-width: 4px;
            transform: scale(1.1);
        }

        .initials {
            font-size: 2.5rem;
            font-weight: 800;
            background: linear-gradient(135deg, #764ba2 0%, #667eea 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .cursor-pointer {
            cursor: pointer;
        }

        .hover-up:hover {
            transform: translateY(-3px);
        }

        .underline {
            text-decoration: underline;
        }

        .italic {
            font-style: italic;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const submitBtn = document.getElementById('submitBtn');
            const confirmModal = new bootstrap.Modal(document.getElementById('confirmVoteModal'));
            const nameSpan = document.getElementById('selectedCandidateName');

            submitBtn.addEventListener('click', function () {
                const selected = document.querySelector('input[name="candidate_id"]:checked');
                if (!selected) {
                    toastr.warning("Please select a candidate first!", "Selection Required");
                    return;
                }

                const candidateName = selected.closest('.col-xl-3').querySelector('h4').textContent;
                nameSpan.textContent = candidateName;
                confirmModal.show();
            });
        });
    </script>
</x-app-layout>