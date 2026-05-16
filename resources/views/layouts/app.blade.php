<!DOCTYPE html>
<html>
<head>
    <title>Smart Garden</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body>

    <div class="sidebar p-3">
    <h4 class="mb-4">
        <img src="" alt="Smart Garden" style="height: 30px; width: auto;">
    </h4>

    <ul class="nav flex-column sidebar-menu">
        <li class="nav-item mb-2">
            <a href="/" class="nav-link {{ request()->is('/') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
        </li>

        <li class="nav-item mb-2">
            <a href="/kontrol" class="nav-link {{ request()->is('kontrol') ? 'active' : '' }}">
                <i class="bi bi-sliders"></i> Kontrol
            </a>
        </li>

        <li class="nav-item mb-2">
            <a href="/histori" class="nav-link {{ request()->is('histori') ? 'active' : '' }}">
                <i class="bi bi-clock-history"></i> Histori
            </a>
        </li>
    </ul>
</div>

    <div class="content">
        @yield('content')
    </div>
<script src="{{ asset('js/custom.js') }}"></script>
</body>
</html>
