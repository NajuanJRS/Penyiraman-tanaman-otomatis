<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Caba.IoT</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/jpeg" href="{{ asset('img/Logo_smart_garden.jpeg') }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns"></script>
    <script src="https://cdn.jsdelivr.net/npm/date-fns@2.30.0/locale/id/index.min.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>

<body
    data-flash-success="{{ session('success') }}"
    data-flash-error="{{ session('error') }}"
>

{{-- ── BlatUI Toast Container ──────────────────────────────────── --}}
<div id="sg-toast-container" aria-live="polite" aria-atomic="true"></div>

{{-- ── BlatUI Confirm Dialog ───────────────────────────────────── --}}
<dialog id="sg-confirm-dialog" class="sg-dialog" aria-modal="true">
    <div class="sg-dialog__panel">
        <div class="sg-dialog__icon-wrap" id="sg-dialog-icon-wrap">
            <svg id="sg-dialog-icon-warning" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>
            </svg>
            <svg id="sg-dialog-icon-danger" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:none">
                <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
            <svg id="sg-dialog-icon-question" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:none">
                <circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 015.83 1c0 2-3 3-3 3"/><line x1="12" y1="17" x2="12.01" y2="17"/>
            </svg>
        </div>
        <div class="sg-dialog__body">
            <p class="sg-dialog__title" id="sg-dialog-title">Konfirmasi</p>
            <p class="sg-dialog__text"  id="sg-dialog-text"></p>
        </div>
        <div class="sg-dialog__actions">
            <button id="sg-dialog-cancel"  class="sg-btn sg-btn--ghost">Batal</button>
            <button id="sg-dialog-confirm" class="sg-btn sg-btn--primary">Konfirmasi</button>
        </div>
    </div>
</dialog>

{{-- Mobile top bar with BlatUI styling --}}
<div class="sg-mobile-navbar">
    <button id="menu-toggle" class="sg-menu-btn" aria-label="Buka menu">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/>
        </svg>
    </button>
    <div class="sg-mobile-brand">
        <img src="{{ asset('img/Logo_smart_garden.jpeg') }}" alt="Smart Garden" class="sg-mobile-logo">
        <span class="sg-mobile-title">Caba.IoT</span>
    </div>
</div>

{{-- Sidebar with BlatUI styling --}}
<aside class="sg-sidebar" id="sidebar">
    {{-- Brand --}}
    <div class="sg-sidebar-brand">
        <div class="sg-brand-logo">
            <img src="{{ asset('img/Logo_smart_garden.jpeg') }}" alt="Smart Garden">
        </div>
        <div class="sg-brand-text">
            <p class="sg-brand-title">Caba.IoT</p>
            <span class="sg-brand-subtitle">Monitoring System</span>
        </div>
    </div>

    {{-- Menu label --}}
    <div class="sg-menu-label">MENU</div>

    {{-- Navigation --}}
    <nav class="sg-nav">
        <a href="/" class="sg-nav-link {{ request()->is('/') ? 'sg-nav-link--active' : '' }}">
            <span class="sg-nav-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/>
                </svg>
            </span>
            <span class="sg-nav-text">Dashboard</span>
        </a>
        <a href="/kontrol" class="sg-nav-link {{ request()->is('kontrol') ? 'sg-nav-link--active' : '' }}">
            <span class="sg-nav-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="4" y1="21" x2="4" y2="14"/><line x1="4" y1="10" x2="4" y2="3"/><line x1="12" y1="21" x2="12" y2="12"/><line x1="12" y1="8" x2="12" y2="3"/><line x1="20" y1="21" x2="20" y2="16"/><line x1="20" y1="12" x2="20" y2="3"/><line x1="1" y1="14" x2="7" y2="14"/><line x1="9" y1="8" x2="15" y2="8"/><line x1="17" y1="16" x2="23" y2="16"/>
                </svg>
            </span>
            <span class="sg-nav-text">Kontrol</span>
        </a>
        <a href="/histori" class="sg-nav-link {{ request()->is('histori') ? 'sg-nav-link--active' : '' }}">
            <span class="sg-nav-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/>
                </svg>
            </span>
            <span class="sg-nav-text">Histori</span>
        </a>
    </nav>

    {{-- Footer / Logout --}}
    <div class="sg-sidebar-footer">
        <a href="javascript:void(0)" onclick="confirmLogout()" class="sg-logout-link">
            <span class="sg-nav-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/>
                </svg>
            </span>
            <span class="sg-nav-text">Logout</span>
        </a>
    </div>
</aside>

{{-- Overlay for mobile sidebar --}}
<div class="sg-sidebar-overlay" id="sidebar-overlay"></div>

{{-- Main content --}}
<div class="content">
    @yield('content')
</div>

<script src="{{ asset('js/custom.js') }}"></script>
<script>
    const toggleBtn = document.getElementById('menu-toggle');
    const sidebar   = document.getElementById('sidebar');
    const overlay   = document.getElementById('sidebar-overlay');

    toggleBtn.addEventListener('click', () => {
        sidebar.classList.toggle('show-sidebar');
        overlay.classList.toggle('show-overlay');
    });

    overlay.addEventListener('click', () => {
        sidebar.classList.remove('show-sidebar');
        overlay.classList.remove('show-overlay');
    });

    // Logout confirmation
    function confirmLogout() {
        if (window.sgConfirm) {
            sgConfirm(
                'Konfirmasi Logout',
                'Apakah Anda yakin ingin keluar dari sistem?',
                'warning'
            ).then(confirmed => {
                if (confirmed) {
                    window.location.href = '{{ route("logout") }}';
                }
            });
        } else {
            // Fallback if confirm system not loaded
            if (confirm('Apakah Anda yakin ingin keluar?')) {
                window.location.href = '{{ route("logout") }}';
            }
        }
    }
</script>

</body>
</html>
