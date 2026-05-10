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
            max-width: 420px;
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

        .page-heading {
            font-size: 1.5rem;
            font-weight: 800;
            color: #ea5c2b;
            text-align: center;
            line-height: 1.25;
            margin-bottom: 0.4rem;
        }

        .subtitle {
            color: #6B7280;
            font-size: 0.82rem;
            text-align: center;
            margin-bottom: 1.25rem;
            line-height: 1.5;
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
            margin: 0.9rem 0;
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
            margin-bottom: 0.3rem;
        }

        .form-control {
            border-radius: 50px !important;
            padding: 0.5rem 1.1rem;
            font-size: 0.9rem;
            border: 1.5px solid #E5E7EB;
            background: linear-gradient(90deg, rgba(149, 205, 65, 0.1) 0%, rgba(234, 92, 43, 0.08) 100%);
        }

        .form-control::placeholder {
            color: #9CA3AF;
        }

        .form-control:focus {
            box-shadow: 0 0 0 0.2rem rgba(234, 92, 43, .25);
            border-color: #ea5c2b;
        }

        .hint-text {
            font-size: 0.75rem;
            color: #9CA3AF;
            padding-left: 0.75rem;
            margin-top: 0.2rem;
        }

        /* === Register Button === */
        .btn-oren {
            background-color: #ea5c2b;
            color: white;
            border-radius: 50px;
            padding: 0.6rem;
            font-size: 1rem;
            transition: all 0.25s ease;
            box-shadow: 0 4px 12px rgba(234, 92, 43, 0.3);
            border: none;
        }

        .btn-oren:hover {
            background-color: #cd4c22;
            color: white;
            transform: translateY(-1px);
            box-shadow: 0 6px 18px rgba(205, 76, 34, 0.4);
        }

        /* === Footer === */
        .link-auth {
            color: #95cd41;
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

            .page-heading {
                font-size: 1.3rem;
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

            <h2 class="page-heading mt-2">Start Your Healthy<br>Journey Today</h2>
            <p class="subtitle">
                Create your NutriPlan account to access personalized meal plans,
                BMI analysis, and a rich catalog of healthy recipes.
            </p>

            {{-- Flash Messages --}}
            @if (session('success'))
                <div class="alert alert-success py-2">{{ session('success') }}</div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger py-2">
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- Google Sign-Up --}}
            <a href="{{ route('auth.google') }}" class="btn-google">
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
                Sign Up With Google
            </a>

            <div class="divider">or</div>

            {{-- Registration Form --}}
            <form method="POST" action="{{ route('register.process') }}">
                @csrf

                <div class="mb-2">
                    <label class="form-label fw-semibold">Name</label>
                    <input type="text" name="name"
                        class="form-control @error('name') is-invalid @enderror"
                        placeholder="Enter your name"
                        value="{{ old('name') }}" required>
                    @error('name')
                        <div class="invalid-feedback ps-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-2">
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
                    <label class="form-label fw-semibold">Age</label>
                    <input type="number" name="umur"
                        class="form-control @error('umur') is-invalid @enderror"
                        placeholder="Contoh: 21"
                        value="{{ old('umur') }}" required>
                    @error('umur')
                        <div class="invalid-feedback ps-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row mb-2">
                    <div class="col-6">
                        <label class="form-label fw-semibold">Weight (kg)</label>
                        <input type="number" name="berat_badan"
                            class="form-control @error('berat_badan') is-invalid @enderror"
                            placeholder="60"
                            value="{{ old('berat_badan') }}" required>
                        @error('berat_badan')
                            <div class="invalid-feedback ps-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-6">
                        <label class="form-label fw-semibold">Height (cm)</label>
                        <input type="number" name="tinggi_badan"
                            class="form-control @error('tinggi_badan') is-invalid @enderror"
                            placeholder="170"
                            value="{{ old('tinggi_badan') }}" required>
                        @error('tinggi_badan')
                            <div class="invalid-feedback ps-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Password</label>
                    <input type="password" name="password"
                        class="form-control @error('password') is-invalid @enderror"
                        placeholder="Enter your password" required>
                    @error('password')
                        <div class="invalid-feedback ps-2">{{ $message }}</div>
                    @enderror
                    <p class="hint-text">Minimal 6 karakter</p>
                </div>

                <button type="submit" class="btn btn-oren w-100 fw-bold">Create Account</button>

            </form>

            <p class="text-center footer-text mt-3 mb-0">
                Already have an account?
                <a href="{{ route('login') }}" class="link-auth">Login here</a>
            </p>

        </div>
    </div>

</body>

</html>