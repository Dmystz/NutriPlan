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
            font-family: "SF Pro Display", -apple-system, sans-serif;
            background: linear-gradient(to top right, #ffd8df, #f0ffdf);
            position: relative;
        }

        html,
        body {
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* === Back Button === */
        .back-btn {
            position: fixed;
            top: 20px;
            left: 25px;
            text-decoration: none;
            color: #ea5c2b;
            font-size: 16px;
            font-weight: bold;
            z-index: 10;
            transition: color 0.2s;
        }

        .back-btn:hover {
            color: #cd4c22;
        }

        /* === Page Layout === */
        .page-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
        }

        /* === Card === */
        .card-auth {
            width: 100%;
            max-width: 400px;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(12px);
            padding: 2rem 2.5rem;
            animation: slideUp 0.5s ease;
            border: none;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* === Brand === */
        .nutri {
            color: #95cd41;
            font-weight: bold;
        }

        .plan {
            color: #ea5c2b;
            font-weight: bold;
        }

        .logo-block {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.4rem;
            margin-bottom: 0.25rem;
        }

        .logo-img {
            width: 40px;
            height: 40px;
            object-fit: contain;
        }

        .brand-name {
            font-size: 1.6rem;
        }

        .subtitle {
            color: #6B7280;
            font-size: 0.9rem;
            margin-bottom: 1.5rem;
        }

        /* === Google Button === */
        .btn-google {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            width: 100%;
            border: none;
            border-radius: 50px;
            padding: 0.55rem 1rem;
            font-weight: 600;
            font-size: 0.95rem;
            cursor: pointer;
            color: white;
            background: linear-gradient(90deg, #95cd41 0%, #ea5c2b 100%);
            transition: opacity 0.2s;
            text-decoration: none;
        }

        .btn-google:hover {
            opacity: 0.88;
            color: white;
        }

        .btn-google svg {
            flex-shrink: 0;
        }

        /* === Divider === */
        .divider {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            color: #9CA3AF;
            font-size: 0.82rem;
            margin: 1rem 0;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #E5E7EB;
        }

        /* === Form === */
        .form-label {
            font-size: 0.9rem;
            margin-bottom: 0.35rem;
        }

        .form-control {
            border-radius: 50px !important;
            padding: 0.5rem 1.1rem;
            font-size: 0.9rem;
            border: 1.5px solid #E5E7EB;
            background: rgba(149, 205, 65, 0.07);
        }

        .form-control:focus {
            box-shadow: 0 0 0 0.2rem rgba(149, 205, 65, .35);
            border-color: #95cd41;
        }

        .form-check-label {
            font-size: 0.88rem;
            color: #374151;
        }

        .form-check-input:checked {
            background-color: #95cd41;
            border-color: #95cd41;
        }

        .form-check-input:focus {
            box-shadow: 0 0 0 0.2rem rgba(149, 205, 65, .3);
        }

        .forgot-link {
            color: #ea5c2b;
            font-size: 0.88rem;
            text-decoration: none;
            font-weight: 600;
        }

        .forgot-link:hover {
            color: #cd4c22;
        }

        /* === Login Button === */
        .btn-ijo {
            background-color: #95cd41;
            color: white;
            border-radius: 50px;
            padding: 0.6rem;
            font-size: 1rem;
            transition: all 0.25s ease;
            box-shadow: 0 4px 12px rgba(149, 205, 65, 0.35);
            border: none;
        }

        .btn-ijo:hover {
            background-color: #6e9c29;
            color: white;
            transform: translateY(-1px);
            box-shadow: 0 6px 18px rgba(110, 156, 41, 0.4);
        }

        /* === Footer === */
        .link-auth {
            color: #ea5c2b;
            text-decoration: none;
            font-weight: bold;
        }

        .footer-text {
            font-size: 0.88rem;
            color: #6B7280;
        }

        /* === Responsive === */
        @media (max-width: 480px) {
            .card-auth {
                padding: 1.5rem 1.25rem;
            }
        }
    </style>
</head>

<body>

    {{-- Back Button --}}
    <a href="{{ route('landing') }}" class="back-btn">← Back</a>

    <div class="page-wrapper">
        <div class="card card-auth">

            {{-- Logo --}}
            <div class="logo-block">
                <img src="{{ asset('img/logo.png') }}" alt="NutriPlan Logo" class="logo-img">
                <span class="brand-name">
                    <span class="nutri">Nutri</span><span class="plan">Plan</span>
                </span>
            </div>

            <h4 class="text-center fw-bold mb-0" style="color:#ea5c2b;">Welcome Back!</h4>
            <p class="text-center subtitle mt-1">Log in to continue your healthy journey with NutriPlan</p>

            {{-- Flash Messages --}}
            @if (session('success'))
                <div class="alert alert-success py-2">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger py-2">{{ session('error') }}</div>
            @endif

            {{-- Google Sign-In --}}
            <a href="#" class="btn-google">
                <svg width="20" height="20" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
                    <path fill="#FFC107"
                        d="M43.6 20.5H42V20H24v8h11.3C33.7 32.3 29.3 35 24 35c-6.1 0-11-4.9-11-11s4.9-11 11-11c2.8 0 5.3 1 7.2 2.7l5.7-5.7C33.4 7.5 28.9 5.5 24 5.5 13.2 5.5 4.5 14.2 4.5 25S13.2 44.5 24 44.5 43.5 35.8 43.5 25c0-1.5-.2-3-.5-4.5h.6z" />
                    <path fill="#FF3D00"
                        d="M6.3 15.7l6.6 4.8C14.6 17 19 14 24 14c2.8 0 5.3 1 7.2 2.7l5.7-5.7C33.4 7.5 28.9 5.5 24 5.5c-7.6 0-14.2 4.4-17.7 10.2z" />
                    <path fill="#4CAF50"
                        d="M24 44.5c4.8 0 9.2-1.8 12.5-4.8l-6.1-5.1C28.6 36.2 26.4 37 24 37c-5.3 0-9.7-3.6-11.3-8.5l-6.6 5.1C9.7 40 16.4 44.5 24 44.5z" />
                    <path fill="#1976D2"
                        d="M43.6 20.5H42V20H24v8h11.3c-.8 2.2-2.2 4.1-4.1 5.5l6.1 5.1c-.4.4 6.7-4.9 6.7-13.6 0-1.5-.2-3-.5-4.5h.1z" />
                </svg>
                Sign In With Google
            </a>

            <div class="divider">or</div>

            {{-- Login Form --}}
            <form method="POST" action="{{ route('login.process') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label fw-semibold">Email</label>
                    <input type="email" name="email"
                        class="form-control @error('email') is-invalid @enderror"
                        placeholder="Enter your email"
                        value="{{ old('email') }}" required>
                    @error('email')
                        <div class="invalid-feedback ps-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-2">
                    <label class="form-label fw-semibold">Password</label>
                    <input type="password" name="password"
                        class="form-control @error('password') is-invalid @enderror"
                        placeholder="Enter your password" required>
                    @error('password')
                        <div class="invalid-feedback ps-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div class="form-check mb-0">
                        <input class="form-check-input" type="checkbox" name="remember" id="rememberMe">
                        <label class="form-check-label" for="rememberMe">Remember me</label>
                    </div>
                    <a href="#" class="forgot-link">Forgot Password?</a>
                </div>

                <button type="submit" class="btn btn-ijo w-100 fw-bold">Login</button>
            </form>

            <p class="text-center footer-text mt-3 mb-0">
                Don't have an account?
                <a href="{{ route('register') }}" class="link-auth">Sign Up</a>
            </p>

        </div>
    </div>

</body>

</html>