<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}">
    <title>Register - NutriPlan</title>
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
        .btn-oren {
            background-color: #ea5c2b;
            color: white;
            border-radius: 50px;
        }
        .btn-oren:hover { background-color: #cd4c22; color: white; }
        .link-auth {
            color: #95cd41;
            text-decoration: none;
            font-weight: bold;
        }
        .form-control:focus {
            box-shadow: 0 0 0 0.2rem rgba(234,92,43,.25);
            border-color: #ea5c2b;
        }
    </style>
</head>
<body>
<div class="d-flex justify-content-center align-items-center vh-100">
    <div class="card card-auth p-4">
        <h3 class="text-center mb-1">
            <span class="nutri">Nutri</span><span class="plan">Plan</span>
        </h3>
        <h5 class="text-center mb-3 text-muted fw-normal">Create Account</h5>

        @if(session('success'))
            <div class="alert alert-success py-2">{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger py-2">
                <ul class="mb-0 ps-3">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register.process') }}">
            @csrf
            <div class="mb-3">
                <label class="form-label fw-semibold">Name</label>
                <input type="text" name="name"
                       class="form-control rounded-pill @error('name') is-invalid @enderror"
                       value="{{ old('name') }}" required>
                @error('name')
                    <div class="invalid-feedback ps-2">{{ $message }}</div>
                @enderror
            </div>
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
                <small class="text-muted ps-2">Minimal 6 karakter</small>
            </div>
            <button type="submit" class="btn btn-oren w-100 mt-3 fw-bold">Sign Up</button>
        </form>

        <p class="text-center mt-3 mb-0">
            Already have an account?
            <a href="{{ route('login') }}" class="link-auth">Login</a>
        </p>
    </div>
</div>
</body>
</html>