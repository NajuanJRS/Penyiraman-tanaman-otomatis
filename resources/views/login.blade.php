<!DOCTYPE html>
<html>

<head>
    <title>Login Smart Garden</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        input::-ms-reveal,
        input::-ms-clear {
            display: none;
        }
    </style>
</head>

<body class="bg-light">

    <div class="container">
        <div class="row justify-content-center mt-5">

            <div class="col-md-4">
                <div class="card shadow">

                    <div class="card-body">

                        <div class="text-center mb-4">
                            <img src="{{ asset('img/Logo_smart_garden.jpeg') }}" alt="Logo"
                                style="max-width: 100px; margin-bottom: 15px;">
                            <h3>Smart Garden</h3>
                        </div>

                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        <form action="{{ route('login.process') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label>Password</label>

                                <div class="input-group">

                                    <input type="password" name="password" id="password" class="form-control" required>

                                    <button type="button" class="btn btn-outline-secondary" id="togglePassword">

                                        <i class="bi bi-eye"></i>

                                    </button>

                                </div>
                            </div>

                            <button type="submit" class="btn btn-success w-100">
                                Login
                            </button>
                        </form>

                    </div>

                </div>
            </div>

        </div>
    </div>
    <script>
        document.getElementById('togglePassword').addEventListener('click', function() {

            const password = document.getElementById('password');
            const icon = this.querySelector('i');

            if (password.type === 'password') {

                password.type = 'text';

                icon.classList.remove('bi-eye');
                icon.classList.add('bi-eye-slash');

            } else {

                password.type = 'password';

                icon.classList.remove('bi-eye-slash');
                icon.classList.add('bi-eye');

            }

        });
    </script>
</body>

</html>
