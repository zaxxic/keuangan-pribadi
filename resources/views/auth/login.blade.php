<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0" />
    <title>Login - Keungan</title>
    <link rel="shortcut icon" href="assets/img/favicon.png" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/css/style.css" />
</head>

<body>
    <div class="container-fluid">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-md-6 col-lg-4">
                <div class="text-center mb-4">
                    <img width="300px" class="img-fluid" src="{{ asset('assets/img/pragos.png') }}" alt="Logo">
                </div>
                <div class="card">
                    <div class="card-body">
                        <h1 class="text-center mb-4">Login</h1>
                        @if (session('message'))
                        <div class="alert alert-info">
                            {{ session('message') }}
                        </div>
                        @endif
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" class="form-control" name="email" value="{{ old('email') }}"
                                    autocomplete="email" autofocus required />
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" class="form-control" name="password" required />
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="remember" name="remember"
                                        {{ old('remember') ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="remember">Remember me</label>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Login</button>
                        </form>
                        <div class="text-center mt-3">
                            <p>Tidak punya akun? <a href="{{ route('register') }}">Register</a></p>
                            <a href="{{ route('password.request') }}">Lupa password?</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
