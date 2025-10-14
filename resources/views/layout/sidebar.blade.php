<style>
    .sidebar[data-background-color=dark] {
        background: #1a2035 !important;
    }
    .logo-header[data-background-color=dark] {
        background: #2e3192 !important;
    }
    .logo-header {
        display: flex;
        justify-content: center; /* centers horizontally */
        align-items: center;    /* centers vertically if height applies */
    }
</style>
<div class="sidebar" data-background-color="dark">
    <div class="sidebar-logo">
        <!-- Logo Header -->
        <div class="logo-header" data-background-color="dark">
            <a href="{{ route('index') }}" class="logo">
                <img
                        src="{{ asset('assets/img/rsf.png') }}"
                        alt="navbar brand"
                        class="navbar-brand"
                        height="100"
                />

            </a>
            <div class="nav-toggle">
                <button class="btn btn-toggle toggle-sidebar">
                    <i class="gg-menu-right"></i>
                </button>
                <button class="btn btn-toggle sidenav-toggler">
                    <i class="gg-menu-left"></i>
                </button>
            </div>
            <button class="topbar-toggler more">
                <i class="gg-more-vertical-alt"></i>
            </button>
        </div>
        <!-- End Logo Header -->
    </div>
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <ul class="nav nav-secondary">
                <li class="nav-item {{ request()->routeIs('index') ? 'active' : '' }}">
                    <a

                            href="{{ route('index') }}"
                            class="collapsed"
                            aria-expanded="false"
                    >
                        <i class="fas fa-home"></i>
                        <p>Dashboard</p>
                        {{--<span class="caret"></span>--}}
                    </a>

                </li>
                <li class="nav-section">
                <span class="sidebar-mini-icon">
                  <i class="fa fa-ellipsis-h"></i>
                </span>
                    <h4 class="text-section">Products Management</h4>
                </li>

                {{--<li class="nav-item {{ request()->routeIs('product.index') ? 'active' : '' }}">--}}
                    {{--<a href="{{ route('product.index') }}">--}}
                        {{--<i class="fas fa-dolly-flatbed"></i>--}}
                        {{--<p>Products</p>--}}
                        {{--<span class="caret"></span>--}}
                    {{--</a>--}}
                {{--</li>--}}
                <li class="nav-item {{ request()->routeIs('product-name.index') ? 'active' : '' }}">
                    <a href="{{ route('product-name.index') }}">
                        <i class="fas fa-box-open"></i>
                        <p>Product Names</p>
                        {{--<span class="caret"></span>--}}
                    </a>
                </li>

                <li class="nav-section">
                <span class="sidebar-mini-icon">
                  <i class="fa fa-ellipsis-h"></i>
                </span>
                    <h4 class="text-section">Main</h4>
                </li>

                <li class="nav-item {{ request()->routeIs('rs8.index') ? 'active' : '' }}">
                    <a href="{{ route('rs8.index') }}">
                        <i class="fas fa-tachometer-alt"></i>
                        <p>RS8</p>
                        {{--<span class="caret"></span>--}}
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('srf.index') ? 'active' : '' }}">
                    <a href="{{ route('srf.index') }}">
                        <i class="fas fa-chess-board"></i>
                        <p>SRF</p>
                        {{--<span class="caret"></span>--}}
                    </a>
                </li>

                {{-- Trash Bin Section --}}
                <li class="nav-section">
                <span class="sidebar-mini-icon">
                    <i class="fa fa-trash"></i>
                </span>
                    <h4 class="text-section">Trash Bin</h4>
                </li>
                <li class="nav-item {{ request()->routeIs('product-name.trash') ? 'active' : '' }}">
                    <a href="{{ route('product-name.trash') }}">
                        <i class="fas fa-trash-alt"></i>
                        <p>Product Names Trash</p>
                    </a>
                </li>
                {{--<li class="nav-item {{ request()->routeIs('product.trash') ? 'active' : '' }}">--}}
                    {{--<a href="{{ route('product.trash') }}">--}}
                        {{--<i class="fas fa-trash-alt"></i>--}}
                        {{--<p>Products Trash</p>--}}
                    {{--</a>--}}
                {{--</li>--}}


            </ul>
        </div>
    </div>
</div>
