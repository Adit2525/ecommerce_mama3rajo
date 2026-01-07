<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin') - MAMA3RAJO</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<style>
    :root {
        --sidebar-width: 260px;
        --sidebar-bg: #1a1a1a;
        --sidebar-hover: #2d2d2d;
        --accent-color: #ffffff;
    }
    
    #wrapper {
        display: flex;
        width: 100%;
        overflow-x: hidden;
    }

    #sidebar-wrapper {
        min-height: 100vh;
        width: var(--sidebar-width);
        background-color: var(--sidebar-bg);
        color: #fff;
        flex-shrink: 0;
        transition: all 0.3s ease;
    }

    .sidebar-heading {
        padding: 1.5rem 1.25rem;
        font-size: 1.2rem;
        font-weight: bold;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        border-bottom: 1px solid #333;
        color: var(--accent-color);
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .list-group-item {
        background-color: transparent;
        color: #ddd;
        border: none;
        padding: 1rem 1.25rem;
        font-size: 0.95rem;
        display: flex;
        align-items: center;
        gap: 12px;
        transition: all 0.2s;
    }

    .list-group-item:hover {
        background-color: var(--sidebar-hover);
        color: #fff;
        padding-left: 1.5rem;
    }

    .list-group-item.active {
        background-color: var(--sidebar-hover);
        color: #fff;
        border-left: 4px solid #fff;
    }

    #page-content-wrapper {
        flex: 1;
        width: 100%;
        background-color: #f8f9fa;
    }
    
    .navbar-top {
        box-shadow: 0 2px 4px rgba(0,0,0,0.04);
        background: white;
    }
</style>
<div id="wrapper">
    <!-- Sidebar -->
    <div id="sidebar-wrapper">
        <div class="sidebar-heading">
            MAMA3RAJO
        </div>
        <div class="list-group list-group-flush py-3">
            <a href="{{ route('admin.dashboard') }}" class="list-group-item list-group-item-action {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <span>Dashboard</span>
            </a>
            <a href="{{ route('admin.products.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                <span>Produk</span>
            </a>
            <a href="{{ route('admin.promotions.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('admin.promotions.*') ? 'active' : '' }}">
                <span>Promosi</span>
            </a>
            <a href="{{ route('admin.orders.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                <span>Pesanan</span>
            </a>
            <a href="{{ route('admin.reports.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
                <span>Laporan</span>
            </a>
            <a href="{{ route('welcome') }}" class="list-group-item list-group-item-action mt-5">
                <span>Lihat Website</span>
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="list-group-item list-group-item-action w-100 text-start">
                    <span>Keluar</span>
                </button>
            </form>
        </div>
    </div>
    
    <!-- Page Content -->
    <div id="page-content-wrapper">
        <nav class="navbar navbar-expand-lg navbar-light navbar-top px-4 py-3">
            <div class="d-flex w-100 justify-content-between align-items-center">
                <h4 class="m-0 text-muted fs-6 text-uppercase fw-bold">@yield('title')</h4>
                
                <div class="d-flex align-items-center gap-3">
                    @auth
                        <div class="dropdown">
                             <a class="text-decoration-none text-dark fw-bold" href="#" role="button">
                                {{ auth()->user()->name }}
                             </a>
                        </div>
                    @endauth
                </div>
            </div>
        </nav>

        <div class="container-fluid px-4 py-4">
            @if(session('success'))
                <div class="alert alert-success border-0 shadow-sm">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger border-0 shadow-sm">{{ session('error') }}</div>
            @endif
            
            @yield('content')
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
