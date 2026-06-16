<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login — Smart Garden</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/jpeg" href="{{ asset('img/Logo_smart_garden.jpeg') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>

    <div class="login-box">

        <div class="login-brand">
            <div class="login-logo">
                <img src="{{ asset('img/Logo_smart_garden.jpeg') }}" alt="Logo">
            </div>
            <span class="login-brand-name">Cabaiot</span>
        </div>

        <h1 class="login-title">Masuk ke Dasbor</h1>
        <p class="login-subtitle">Sistem monitoring tanaman otomatis.</p>

        @if (session('error'))
            <div class="login-error">
                <i class="bi bi-exclamation-circle"></i>
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('login.process') }}" method="POST">
            @csrf

            <label for="password" class="field-label">Password</label>
            <div class="field-wrap">
                <span class="field-icon"><i class="bi bi-lock"></i></span>
                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Masukkan password"
                    autocomplete="current-password"
                    required
                >
                <button type="button" class="toggle-pw" id="togglePw" aria-label="Tampilkan password">
                    <i class="bi bi-eye"></i>
                </button>
            </div>

            <button type="submit" class="btn-submit">Masuk</button>
        </form>

    </div>

    <script>
        const btn = document.getElementById('togglePw');
        const inp = document.getElementById('password');
        btn.addEventListener('click', () => {
            const show = inp.type === 'password';
            inp.type = show ? 'text' : 'password';
            btn.querySelector('i').className = show ? 'bi bi-eye-slash' : 'bi bi-eye';
            btn.setAttribute('aria-label', show ? 'Sembunyikan password' : 'Tampilkan password');
        });
    </script>

</body>
</html>
