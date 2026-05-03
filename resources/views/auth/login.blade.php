<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}">
    <title>Login - NutriPlan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: "SF Pro Display", sans-serif;
            background: linear-gradient(to top right, #ffd8df, #f0ffdf);
        }
        .card-auth {
            width: 100%;
            max-width: 400px;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        }
        .nutri { color: #95cd41; font-weight: bold; }
        .plan  { color: #ea5c2b; font-weight: bold; }
        .btn-ijo {
            background-color: #95cd41;
            color: white;
            border-radius: 50px;
        }
        .btn-ijo:hover { background-color: #6e9c29; color: white; }
        .link-auth {
            color: #ea5c2b;
            text-decoration: none;
            font-weight: bold;
        }
        .form-control:focus {
            box-shadow: 0 0 0 0.2rem rgba(149,205,65,.35);
            border-color: #95cd41;
        }
    </style>
</head>
<body>
<div class="d-flex justify-content-center align-items-center vh-100">
    <div class="card card-auth p-4">
        <h3 class="text-center mb-1">
            <span class="nutri">Nutri</span><span class="plan">Plan</span>
        </h3>
        <h5 class="text-center mb-3 text-muted fw-normal">Welcome Back!</h5>

        @if(session('success'))
            <div class="alert alert-success py-2">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger py-2">{{ session('error') }}</div>
        @endif

        <form method="POST" action="{{ route('login.process') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label fw-semibold">Email</label>
                <input type="email" name="email"
                       class="form-control rounded-pill @error('email') is-invalid @enderror"
                       value="{{ old('email') }}" required>
                @error('email')
                    <div class="invalid-feedback ps-2">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">Password</label>
                <input type="password" name="password"
                       class="form-control rounded-pill @error('password') is-invalid @enderror"
                       required>
                @error('password')
                    <div class="invalid-feedback ps-2">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-ijo w-100 mt-2 fw-bold">Login</button>
        </form>

        <p class="text-center mt-3 mb-0">
            Belum punya akun?
            <a href="{{ route('register') }}" class="link-auth">Daftar</a>
        </p>
    </div>
</div>
</body>
</html>