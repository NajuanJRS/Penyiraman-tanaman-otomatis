<!DOCTYPE html>
<html lang="id">

<head>
    <title>Login Smart Garden</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/jpeg" href="{{ asset('img/Logo_smart_garden.jpeg') }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>

<body>
    <main class="login-page">
        <section class="login-shell" aria-label="Login Smart Garden">
            <div class="login-visual">
                <div class="brand-mark">
                    <img src="{{ asset('img/Logo_smart_garden.jpeg') }}" alt="Logo Smart Garden">
                    <span>Smart Garden</span>
                </div>

                <div class="visual-copy">
                    <h1>Pantau kebun dari satu ruang kendali.</h1>
                    <p>
                        Masuk untuk melihat kondisi tanaman, mengontrol perangkat, dan menjaga lingkungan kebun tetap
                        ideal setiap saat.
                    </p>
                </div>

                <div class="status-row" aria-label="Fitur Smart Garden">
                    <div class="status-item">
                        <i class="bi bi-moisture"></i>
                        <span>Sensor</span>
                        <strong>Realtime</strong>
                    </div>
                    <div class="status-item">
                        <i class="bi bi-sliders"></i>
                        <span>Kontrol</span>
                        <strong>Praktis</strong>
                    </div>
                    <div class="status-item">
                        <i class="bi bi-graph-up-arrow"></i>
                        <span>Histori</span>
                        <strong>Tercatat</strong>
                    </div>
                </div>
            </div>

            <div class="login-panel">
                <div class="login-card">
                    <img src="{{ asset('img/Logo_smart_garden.jpeg') }}" alt="Logo Smart Garden" class="mobile-logo">

                    <div class="login-heading">
                        <div class="eyebrow">
                            <i class="bi bi-shield-lock"></i>
                            Area Admin
                        </div>
                        <h2>Selamat Datang</h2>
                        <p>Gunakan password admin untuk masuk ke dashboard Smart Garden.</p>
                    </div>

                    @if (session('error'))
                        <div class="alert alert-danger d-flex align-items-center gap-2 mb-4">
                            <i class="bi bi-exclamation-circle"></i>
                            <span>{{ session('error') }}</span>
                        </div>
                    @endif

                    <form action="{{ route('login.process') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label for="password" class="form-label">Password</label>
                            <div class="input-group password-field">
                                <span class="input-group-text">
                                    <i class="bi bi-key"></i>
                                </span>

                                <input type="password" name="password" id="password" class="form-control"
                                    placeholder="Masukkan password" autocomplete="current-password" required>

                                <button type="button" class="btn" id="togglePassword" aria-label="Tampilkan password">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-login w-100">
                            <i class="bi bi-box-arrow-in-right me-2"></i>
                            Login
                        </button>
                    </form>

                    <div class="helper-note">
                        <i class="bi bi-info-circle"></i>
                        <span>Akses hanya untuk pengelola sistem monitoring dan kontrol Smart Garden.</span>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <script>
        document.getElementById('togglePassword').addEventListener('click', function() {
            const password = document.getElementById('password');
            const icon = this.querySelector('i');
            const isHidden = password.type === 'password';

            password.type = isHidden ? 'text' : 'password';
            icon.classList.toggle('bi-eye', !isHidden);
            icon.classList.toggle('bi-eye-slash', isHidden);
            this.setAttribute('aria-label', isHidden ? 'Sembunyikan password' : 'Tampilkan password');
        });
    </script>
</body>

</html>
