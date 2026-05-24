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

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>

<!-- MOBILE NAVBAR -->
<div class="mobile-navbar d-md-none">

    <button class="btn btn-light" id="menu-toggle">
        <i class="bi bi-list"></i>
    </button>

    <div class="d-flex align-items-center">
        <img src="{{ asset('img/Logo_smart_garden.jpeg') }}"
             alt="Smart Garden"
             style="height:35px;width:auto;">

        <span class="ms-2 fw-bold">
            Smart Garden
        </span>
    </div>

</div>

<!-- SIDEBAR -->
<div class="sidebar p-3" id="sidebar">

    <h4 class="sidebar-title mb-4" style="color:white;">
        <img src="{{ asset('img/Logo_smart_garden.jpeg') }}"
             alt="Smart Garden"
             style="height: 30px; width: auto; border-radius:8px; margin-right:8px;">
        Smart Garden
    </h4>

    <ul class="nav flex-column sidebar-menu">

        <li class="nav-item mb-2">
            <a href="/"
               class="nav-link {{ request()->is('/') ? 'active' : '' }}">

                <i class="bi bi-speedometer2"></i>
                Dashboard

            </a>
        </li>

        <li class="nav-item mb-2">
            <a href="/kontrol"
               class="nav-link {{ request()->is('kontrol') ? 'active' : '' }}">

                <i class="bi bi-sliders"></i>
                Kontrol

            </a>
        </li>

        <li class="nav-item mb-2">
            <a href="/histori"
               class="nav-link {{ request()->is('histori') ? 'active' : '' }}">

                <i class="bi bi-clock-history"></i>
                Histori

            </a>
        </li>

    </ul>

</div>

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
