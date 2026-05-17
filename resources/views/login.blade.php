<!DOCTYPE html>
<html>
<head>
    <title>Login Smart Garden</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container">
    <div class="row justify-content-center mt-5">

        <div class="col-md-4">
            <div class="card shadow">

                <div class="card-body">

                    <div class="text-center mb-4">
                        <img src="{{ asset('img/Logo_smart_garden.jpeg') }}" alt="Logo" style="max-width: 100px; margin-bottom: 15px;">
                        <h3>Smart Garden</h3>
                    </div>

                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('login.process') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label>Password</label>
                            <input type="password" name="password" class="form-control" required>
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

</body>
</html>
