<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login — Caba.IoT</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Login ke sistem monitoring tanaman Caba.IoT.">
    <link rel="icon" type="image/jpeg" href="{{ asset('img/Logo_smart_garden.jpeg') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body class="lg-page">

<div class="lg-wrap">

    {{-- ── Left Panel: Brand ───────────────────────────────── --}}
    <div class="lg-brand-panel">
        <div class="lg-brand-inner">

            {{-- Decorative circles --}}
            <div class="lg-deco lg-deco--1"></div>
            <div class="lg-deco lg-deco--2"></div>
            <div class="lg-deco lg-deco--3"></div>

            {{-- Logo --}}
            <div class="lg-logo-wrap">
                <img src="{{ asset('img/Logo_smart_garden.jpeg') }}" alt="Smart Garden Logo">
            </div>

            <h1 class="lg-app-name">Caba.IoT</h1>
            <p class="lg-app-tagline">Sistem Monitoring &amp; Penyiraman<br>Tanaman Otomatis Berbasis IoT</p>

            {{-- Feature pills --}}
            <div class="lg-features">
                <div class="lg-feature">
                    <span class="lg-feature-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2C6.48 2 2 9 2 13a10 10 0 0020 0C22 9 17.52 2 12 2z"/></svg>
                    </span>
                    Monitoring Kelembapan Realtime
                </div>
                <div class="lg-feature">
                    <span class="lg-feature-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    </span>
                    Histori Data Sensor Lengkap
                </div>
                <div class="lg-feature">
                    <span class="lg-feature-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
                    </span>
                    Kontrol Pompa Otomatis &amp; Manual
                </div>
            </div>
        </div>
    </div>

    {{-- ── Right Panel: Form ───────────────────────────────── --}}
    <div class="lg-form-panel">
        <div class="lg-form-inner">

            {{-- Mobile logo (hidden on desktop) --}}
            <div class="lg-mobile-brand">
                <div class="lg-mobile-logo">
                    <img src="{{ asset('img/Logo_smart_garden.jpeg') }}" alt="Logo">
                </div>
                <span>Caba.IoT</span>
            </div>

            <div class="lg-form-header">
                <h2 class="lg-form-title">Selamat Datang</h2>
                <p class="lg-form-subtitle">Masukkan password untuk mengakses dasbor</p>
            </div>

            @if (session('error'))
                <div class="lg-alert lg-alert--error">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('login.process') }}" method="POST" class="lg-form">
                @csrf

                <div class="lg-field">
                    <label for="password" class="lg-label">Password</label>
                    <div class="lg-input-wrap">
                        <span class="lg-input-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                        </span>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="Masukkan password"
                            autocomplete="current-password"
                            required
                            class="lg-input"
                        >
                        <button type="button" id="togglePw" class="lg-toggle-pw" aria-label="Tampilkan password">
                            <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        </button>
                    </div>
                </div>

                <button type="submit" class="lg-btn-submit">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
                    Masuk ke Dasbor
                </button>
            </form>
        </div>
    </div>

</div>

<script>
    const btn = document.getElementById('togglePw');
    const inp = document.getElementById('password');
    const eyeIcon = document.getElementById('eyeIcon');
    const eyeSlash = `<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/>`;
    const eyeOpen  = `<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>`;

    btn.addEventListener('click', () => {
        const show = inp.type === 'password';
        inp.type = show ? 'text' : 'password';
        eyeIcon.innerHTML = show ? eyeSlash : eyeOpen;
        btn.setAttribute('aria-label', show ? 'Sembunyikan password' : 'Tampilkan password');
    });
</script>

</body>
</html>
