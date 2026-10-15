<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<div class="container-fluid vh-100 d-flex align-items-center justify-content-center">
    <div class="row w-100 h-100 g-0">
        <!-- Gambar di sebelah kiri -->
        <div class="col-sm-6 d-none d-sm-block bg-image"></div>

        <!-- Form di sebelah kanan -->
        <div class="col-sm-6 d-flex flex-column justify-content-center align-items-center p-5">
            <div class="text-center">
                <div class="h3 fw-light">Welcome Back</div>
                <p class="mb-4 text-muted">Login your account</p>
            </div>

            <!-- Form Register -->
            <form method="POST" action="{{ route('login') }}" class="w-100" style="max-width: 400px;">
                @csrf

                <div class="form-floating mb-3">
                    <input type="email" id="email" name="email"
                        class="form-control @error('email') is-invalid @enderror" placeholder="name@example.com"
                        value="{{ old('email') }}" required autofocus>
                    <label for="email">Email address</label>
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-floating mb-3">
                    <input type="password" id="password" name="password"
                        class="form-control @error('password') is-invalid @enderror" placeholder="Password" required>
                    <label for="password">Password</label>
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember"
                        {{ old('remember') ? 'checked' : '' }}>
                    <label class="form-check-label" for="remember">
                        Remember me
                    </label>
                </div>

                <div class="d-grid">
                    <button class="btn btn-lg btn-primary btn-login text-uppercase fw-bold mb-2" type="submit">Sign
                        in</button>
                    <div class="text-center">
                        <a class="small" href="{{ route('password.request') }}">Forgot password?</a>
                    </div>
                </div>

                <div class="text-center mt-3">
                    <a class="small" href="{{ route('register') }}">Don't have an account? Register</a>
                </div>
            </form>
            <!-- End of Register Form -->
        </div>
    </div>
</div>

<style>
    body {
        overflow: hidden;
        background: linear-gradient(to right, #ffffff, #f8f8f8);
    }

    .bg-image {
        background-image: url('https://images.unsplash.com/photo-1486556396467-d83d2b23514b?w=500&auto=format&fit=crop&q=60');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        height: 100vh;
    }

    .container-fluid {
        padding: 0;
        margin: 0;
    }
</style>
