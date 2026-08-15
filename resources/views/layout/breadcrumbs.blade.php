@php
    $userRole = auth()->user()->role;
    $homeRoute = match ($userRole) {
        'admin' => 'admin.index',
        'csr_rs8' => 'csr_rs8.index',
        'csr_srf' => 'csr_srf.index',
        default => 'login',
    };

    $currentLabel = match (true) {
        request()->routeIs('admin.rs8.*', 'csr_rs8.rs8.*') => 'RS8 Warranty',
        request()->routeIs('admin.srf.*', 'csr_srf.srf.*') => 'SRF Warranty',
        request()->routeIs('product-name.trash') => 'Product Trash',
        request()->routeIs('product-name.*') => 'Product Names',
        request()->routeIs('user.*') => 'Manage Users',
        request()->routeIs('product.*') => 'Products',
        default => 'Dashboard',
    };
@endphp

<div class="page-header">
    <ul class="breadcrumbs mb-0">
        <li class="nav-home">
            <a href="{{ route($homeRoute) }}" aria-label="Dashboard"><i class="icon-home"></i></a>
        </li>
        <li class="separator"><i class="icon-arrow-right"></i></li>
        <li class="nav-item">{{ $currentLabel }}</li>
    </ul>
</div>
