@php
    $userRole = auth()->user()->role;
    $dashboardRoute = match ($userRole) {
        'admin' => 'admin.index',
        'csr_rs8' => 'csr_rs8.index',
        'csr_srf' => 'csr_srf.index',
        default => 'login',
    };

    $brandLogo = match ($userRole) {
        'csr_rs8' => 'assets/img/rs8-brand.png',
        'csr_srf' => 'assets/img/srf-brand.png',
        default => 'assets/img/favicon.png',
    };

    $brandLabel = match ($userRole) {
        'csr_rs8' => 'RS8 Warranty Operations',
        'csr_srf' => 'SRF Warranty Operations',
        default => 'Warranty Control Center',
    };

    $workspaceHint = match ($userRole) {
        'admin' => 'Central admin workspace',
        'csr_rs8' => 'RS8 customer support workflow',
        'csr_srf' => 'SRF customer support workflow',
        default => 'Warranty workspace',
    };
@endphp

<div class="sidebar" data-background-color="dark">
    <div class="sidebar-logo">
        <div class="logo-header" data-background-color="dark">
            <a href="{{ route($dashboardRoute) }}" class="logo" aria-label="{{ $brandLabel }}">
                <span class="sidebar-brand-mark">
                    <img src="{{ asset($brandLogo) }}" alt="{{ $brandLabel }}">
                </span>
                <span class="sidebar-brand-copy">
                    <strong>{{ $brandLabel }}</strong>
                    <small>{{ $workspaceHint }}</small>
                </span>
            </a>

            <div class="nav-toggle sidebar-toggle-desktop">
                <button type="button" class="btn btn-toggle universal-sidebar-toggler" aria-label="Toggle sidebar" aria-expanded="true">
                    <i class="gg-menu-left"></i>
                </button>
            </div>
        </div>
    </div>

    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <ul class="nav nav-secondary">
                <li class="nav-section">
                    <h4 class="text-section">Overview</h4>
                </li>

                <li class="nav-item {{ request()->routeIs($dashboardRoute) ? 'active' : '' }}">
                    <a href="{{ route($dashboardRoute) }}" title="Dashboard" aria-label="Dashboard">
                        <i class="fas fa-th-large"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                @if ($userRole === 'admin')
                    <li class="nav-section">
                        <h4 class="text-section">Management</h4>
                    </li>

                    <li class="nav-item {{ request()->routeIs('product-name.index') ? 'active' : '' }}">
                        <a href="{{ route('product-name.index') }}" title="Product Names" aria-label="Product Names">
                            <i class="fas fa-box-open"></i>
                            <p>Product Names</p>
                        </a>
                    </li>

                    <li class="nav-item {{ request()->routeIs('user.index') ? 'active' : '' }}">
                        <a href="{{ route('user.index') }}" title="Manage Users" aria-label="Manage Users">
                            <i class="fas fa-users"></i>
                            <p>Manage Users</p>
                        </a>
                    </li>
                @endif

                <li class="nav-section">
                    <h4 class="text-section">Warranty Channels</h4>
                </li>

                @if ($userRole === 'admin')
                    <li class="nav-item {{ request()->routeIs('admin.rs8.index') ? 'active' : '' }}">
                        <a href="{{ route('admin.rs8.index') }}" title="RS8 Warranty" aria-label="RS8 Warranty">
                            <i class="fas fa-bolt"></i>
                            <p>RS8 Warranty</p>
                        </a>
                    </li>
                @elseif ($userRole === 'csr_rs8')
                    <li class="nav-item {{ request()->routeIs('csr_rs8.rs8.index') ? 'active' : '' }}">
                        <a href="{{ route('csr_rs8.rs8.index') }}" title="RS8 Warranty" aria-label="RS8 Warranty">
                            <i class="fas fa-bolt"></i>
                            <p>RS8 Warranty</p>
                        </a>
                    </li>
                @endif

                @if ($userRole === 'admin')
                    <li class="nav-item {{ request()->routeIs('admin.srf.index') ? 'active' : '' }}">
                        <a href="{{ route('admin.srf.index') }}" title="SRF Warranty" aria-label="SRF Warranty">
                            <i class="fas fa-flag-checkered"></i>
                            <p>SRF Warranty</p>
                        </a>
                    </li>
                @elseif ($userRole === 'csr_srf')
                    <li class="nav-item {{ request()->routeIs('csr_srf.srf.index') ? 'active' : '' }}">
                        <a href="{{ route('csr_srf.srf.index') }}" title="SRF Warranty" aria-label="SRF Warranty">
                            <i class="fas fa-flag-checkered"></i>
                            <p>SRF Warranty</p>
                        </a>
                    </li>
                @endif

                @if ($userRole === 'admin')
                    <li class="nav-section">
                        <h4 class="text-section">Recovery</h4>
                    </li>
                    <li class="nav-item {{ request()->routeIs('product-name.trash') ? 'active' : '' }}">
                        <a href="{{ route('product-name.trash') }}" title="Product Trash" aria-label="Product Trash">
                            <i class="fas fa-trash"></i>
                            <p>Product Trash</p>
                        </a>
                    </li>
                @endif
            </ul>

        </div>
    </div>
</div>
