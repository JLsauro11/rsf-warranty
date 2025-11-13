@push('css')
<style>
    .breadcrumbs {

        padding-left: 0;
        margin-left: 18px;
        display: flex;
        justify-content: flex-start;
        align-items: center;
        width: 100%;
    }
</style>
@endpush

@php
    $userRole = auth()->user()->role;
@endphp

<div class="page-header">
    <ul class="breadcrumbs mb-3">
        <li class="nav-home">
            <a href="{{
                $userRole === 'admin' ? route('admin.index') : (
                    $userRole === 'csr_rs8' ? route('csr_rs8.index') : route('csr_srf.index')
                )
            }}">
                <i class="icon-home"></i>
            </a>
        </li>
        <li class="separator">
            <i class="icon-arrow-right"></i>
        </li>
        @if(request()->routeIs('rs8.index'))
            <li class="nav-item">RS8 Clients</li>
        @elseif(request()->routeIs('srf.index'))
            <li class="nav-item">SRF Clients</li>
        @elseif(request()->routeIs('product.index'))
            <li class="nav-item">Products</li>
        @elseif(request()->routeIs('product-name.index'))
            <li class="nav-item">Product Names</li>
        @elseif(request()->routeIs('product-name.trash'))
            <li class="nav-item">Product Names Trash</li>
        @endif
    </ul>
</div>

