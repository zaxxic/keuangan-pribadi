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
                        <h1 class="text-center mb-4">Register</h1>
                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="form-group">
                                <label class="form-control-label">Nama</label>
                                <input id="name" type="text"
                                    class="form-control @error('name') is-invalid @enderror"
                                    name="name" value="{{ old('name') }}" autocomplete="name"
                                    autofocus>

    <div class="container-fluid">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-md-6 col-lg-4">
                <div class="text-center mb-4">
                    <img width="300px" class="img-fluid" src="{{ asset('assets/img/pragos.png') }}" alt="Logo">
                </div>
                <div class="text-center mb-4">
                    <div class="loginbox">
                        <div class="login-right">
                            <div class="login-right-wrap">
                                <h1>Register</h1>
                                <p class="account-subtitle">Untuk akses layanan kami</p>

                                <form method="POST" action="{{ route('register') }}">
                                    @csrf
                                    <div class="form-group">
                                        <label class="form-control-label">Nama</label>
                                        <input id="name" type="text"
                                            class="form-control @error('name') is-invalid @enderror" name="name"
                                            value="{{ old('name') }}" autocomplete="name" autofocus>

                                        @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label class="form-control-label">Alamat email</label>
                                        <input id="email" type="text"
                                            class="form-control @error('email') is-invalid @enderror" name="email"
                                            value="{{ old('email') }}" autocomplete="email">

                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label class="form-control-label">Password</label>
                                        <input id="password" type="password"
                                            class="form-control @error('password') is-invalid @enderror" name="password"
                                            autocomplete="new-password">

                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <label class="form-control-label">Konfirmasi Password</label>
                                        <input id="password-confirm" type="password"
                                            class="form-control @error('password_confirmation') is-invalid @enderror"
                                            name="password_confirmation" autocomplete="new-password">

                                        @error('password_confirmation')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="form-group mb-0">
                                        <button class="btn btn-lg btn-block btn-primary w-100"
                                            type="submit">Register</button>
                                    </div>
                                </form>

                                <div class="text-center dont-have">Sudah punya akun? <a
                                        href="{{ Route('login') }}">Login</a>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-control-label">Alamat email</label>
                                <input id="email" type="text"
                                    class="form-control @error('email') is-invalid @enderror"
                                    name="email" value="{{ old('email') }}" autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="form-control-label">Password</label>
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    name="password" autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="form-control-label">Konfirmasi Password</label>
                                <input id="password-confirm" type="password"
                                    class="form-control @error('password_confirmation') is-invalid @enderror"
                                    name="password_confirmation" autocomplete="new-password">

                                @error('password_confirmation')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group mb-0">
                                <button class="btn btn-lg btn-block btn-primary w-100"
                                    type="submit">Register</button>
                            </div>
                        </form>

                        <div class="text-center mt-3">
                            <p>Sudah punya akun? <a href="{{ route('login') }}">Login</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <script src="{{ asset('assets/js/jquery-3.7.0.min.js') }}"></script>

        <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>

        <script src="{{ asset('assets/js/feather.min.js') }}"></script>

        <script src="{{ asset('assets/js/script.js') }}"></script>
</body>

</html>
