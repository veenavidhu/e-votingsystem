{{-- Sidebar Navigation: Includes role-based links and User profile summary --}}
<div class="sidebar p-3 text-white">
    <a href="{{ route('dashboard') }}"
        class="d-flex align-items-center mb-5 mt-3 px-2 text-decoration-none text-white hover-opacity">
        <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="white" class="bi bi-box-seam me-3"
            viewBox="0 0 16 16">
            <path
                d="M8.186 1.113a.5.5 0 0 0-.372 0L1.846 3.5l2.404.961L10.404 2zm3.564 1.426L5.708 4.634l2.4 1.258 5.708-2.3zM14.5 5.144L8.5 7.572V15l6-2.428V5.144zM7.5 15V7.572L1.5 5.144V12.572L7.5 15z" />
        </svg>
        <span class="h4 fw-bold mb-0 text-uppercase tracking-wider">E-voting</span>
    </a>

    <ul class="nav nav-pills flex-column mb-auto px-1">
        <li class="nav-item mb-2">
            <a href="{{ route('dashboard') }}"
                class="nav-link text-white py-3 px-4 d-flex align-items-center {{ request()->routeIs('dashboard') ? 'active-menu-item shadow-sm' : 'opacity-75 hover-bg-light' }}">
                <i class="bi bi-speedometer2 me-3 fs-5"></i>
                Dashboard
            </a>
        </li>
        {{-- Voter-specific links --}}
        @if(Auth::user()->role === 'voter')
            <li class="nav-item mb-2">
                <a href="{{ route('voting.index') }}"
                    class="nav-link text-white py-3 px-4 d-flex align-items-center {{ request()->routeIs('voting.index') ? 'active-menu-item shadow-sm' : 'opacity-75 hover-bg-light' }}">
                    <i class="bi bi-box-seam me-3 fs-5"></i>
                    Voting Booth
                </a>
            </li>
        @endif
        {{-- Admin-specific management links --}}
        @if(Auth::user()->role === 'admin')
            <li class="nav-item mb-2">
                <a href="{{ route('admin.users.index') }}"
                    class="nav-link text-white py-3 px-4 d-flex align-items-center {{ request()->routeIs('admin.users.*') ? 'active-menu-item shadow-sm' : 'opacity-75 hover-bg-light' }}">
                    <i class="bi bi-people me-3 fs-5"></i>
                    User Management
                </a>
            </li>
            <li class="nav-item mb-2">
                <a href="{{ route('admin.candidates.index') }}"
                    class="nav-link text-white py-3 px-4 d-flex align-items-center {{ request()->routeIs('admin.candidates.*') ? 'active-menu-item shadow-sm' : 'opacity-75 hover-bg-light' }}">
                    <i class="bi bi-person-badge me-3 fs-5"></i>
                    Candidates
                </a>
            </li>
            <li class="nav-item mb-2">
                <a href="{{ route('admin.results') }}"
                    class="nav-link text-white py-3 px-4 d-flex align-items-center {{ request()->routeIs('admin.results') ? 'active-menu-item shadow-sm' : 'opacity-75 hover-bg-light' }}">
                    <i class="bi bi-bar-chart-line me-3 fs-5"></i>
                    Election Results
                </a>
            </li>
            <li class="nav-item mb-2">
                <a href="{{ route('admin.reports') }}"
                    class="nav-link text-white py-3 px-4 d-flex align-items-center {{ request()->routeIs('admin.reports') ? 'active-menu-item shadow-sm' : 'opacity-75 hover-bg-light' }}">
                    <i class="bi bi-clipboard-data me-3 fs-5"></i>
                    Voting Reports
                </a>
            </li>
        @endif
        <li class="nav-item mb-2">
            <a href="{{ route('profile.edit') }}"
                class="nav-link text-white py-3 px-4 d-flex align-items-center {{ request()->routeIs('profile.edit') ? 'active-menu-item shadow-sm' : 'opacity-75 hover-bg-light' }}">
                <i class="bi bi-person me-3 fs-5"></i>
                My Profile
            </a>
        </li>
    </ul>

    <hr class="bg-white opacity-25 my-4">

    <div class="px-2 mt-auto pb-4">
        <div class="d-flex align-items-center mb-4 p-2 rounded-4 bg-white bg-opacity-10">
            <div class="rounded-circle bg-white bg-opacity-20 d-flex align-items-center justify-content-center me-3"
                style="width: 45px; height: 45px;">
                <i class="bi bi-person fs-5"></i>
            </div>
            <div class="overflow-hidden">
                <div class="fw-bold text-truncate small">{{ Auth::user()->name }}</div>
                <div class="text-white text-opacity-50 text-truncate x-small" style="font-size: 0.75rem;">
                    {{ Auth::user()->email }}
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="btn btn-outline-light w-100 rounded-pill py-2 font-weight-bold d-flex align-items-center justify-content-center"
                onclick="event.preventDefault(); this.closest('form').submit();">
                <i class="bi bi-box-arrow-right me-2"></i>Sign Out
            </button>
        </form>
    </div>
</div>

<style>
    .nav-link {
        transition: all 0.2s ease;
        border-radius: 12px;
        margin: 0 4px;
    }

    .hover-bg-light:hover {
        background: rgba(255, 255, 255, 0.1);
        opacity: 1 !important;
        transform: translateX(4px);
    }

    .active-menu-item {
        background: rgba(255, 255, 255, 0.2) !important;
        border-left: 4px solid #fff !important;
        border-radius: 4px 12px 12px 4px !important;
        font-weight: 600;
        opacity: 1 !important;
    }

    .active-menu-item i {
        color: #fff !important;
    }

    .hover-opacity:hover {
        opacity: 0.8;
        transition: 0.3s;
    }
</style>