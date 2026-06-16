<!DOCTYPE html>
<html>
<head>
    <title>Smart Garden</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/jpeg" href="{{ asset('img/Logo_smart_garden.jpeg') }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="https://cdn.jsdelivr.net/npm/date-fns@2.30.0/locale/id/index.min.js"></script>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>

<!-- MOBILE NAVBAR -->
<div class="mobile-navbar d-md-none">

    <button class="btn btn-light" id="menu-toggle" aria-label="Buka menu">
        <i class="bi bi-list"></i>
    </button>

    <div class="mobile-brand">
        <img src="{{ asset('img/Logo_smart_garden.jpeg') }}"
             alt="Smart Garden">

        <span>
            Smart Garden
        </span>
    </div>

</div>

<!-- SIDEBAR -->
<aside class="sidebar" id="sidebar">

    <div class="sidebar-brand">
        <div class="brand-logo">
            <img src="{{ asset('img/Logo_smart_garden.jpeg') }}"
                 alt="Smart Garden">
        </div>

        <div>
            <h4 class="sidebar-title">
                Smart Garden
            </h4>
            <span class="sidebar-subtitle">
                Monitoring System
            </span>
        </div>
    </div>

    <div class="sidebar-status">
        <div class="status-icon">
            <i class="bi bi-broadcast-pin"></i>
        </div>
        <div>
            <span>Panel aktif</span>
            <strong>Perangkat kebun siap dipantau</strong>
        </div>
    </div>

    <div class="sidebar-section-label">
        Menu Utama
    </div>

    <ul class="nav flex-column sidebar-menu">

        <li class="nav-item">
            <a href="/"
               class="nav-link {{ request()->is('/') ? 'active' : '' }}">

                <span class="nav-icon">
                    <i class="bi bi-speedometer2"></i>
                </span>
                <span>Dashboard</span>

            </a>
        </li>

        <li class="nav-item">
            <a href="/kontrol"
               class="nav-link {{ request()->is('kontrol') ? 'active' : '' }}">

                <span class="nav-icon">
                    <i class="bi bi-sliders"></i>
                </span>
                <span>Kontrol</span>

            </a>
        </li>

        <li class="nav-item">
            <a href="/histori"
               class="nav-link {{ request()->is('histori') ? 'active' : '' }}">

                <span class="nav-icon">
                    <i class="bi bi-clock-history"></i>
                </span>
                <span>Histori</span>

            </a>
        </li>

    </ul>

    <div class="sidebar-footer">
        <a href="{{ route('logout') }}" class="logout-link">
            <span class="nav-icon">
                <i class="bi bi-box-arrow-left"></i>
            </span>
            <span>Logout</span>
        </a>
    </div>

</aside>

<!-- OVERLAY -->
<div class="sidebar-overlay" id="sidebar-overlay"></div>

<!-- CONTENT -->
<div class="content">
    @yield('content')
</div>

<script src="{{ asset('js/custom.js') }}"></script>

<script>

const toggleBtn = document.getElementById('menu-toggle');
const sidebar = document.getElementById('sidebar');
const overlay = document.getElementById('sidebar-overlay');

toggleBtn.addEventListener('click', () => {

    sidebar.classList.toggle('show-sidebar');

    overlay.classList.toggle('show-overlay');

});

overlay.addEventListener('click', () => {

    sidebar.classList.remove('show-sidebar');

    overlay.classList.remove('show-overlay');

});

</script>

</body>
</html>
