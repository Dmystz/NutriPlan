<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}">
    <title>Forgot Password - NutriPlan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: "SF Pro Display", -apple-system, sans-serif;
            background: linear-gradient(to top right, #ffd8df, #f0ffdf);
        }

        html, body {
            min-height: 100vh;
            overflow-x: hidden;
        }

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

        .back-btn:hover { color: #cd4c22; }

        .page-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
        }

        .card-auth {
            width: 100%;
            max-width: 400px;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            background: rgba(255, 248, 240, 0.92);
            backdrop-filter: blur(12px);
            padding: 2rem 2.5rem;
            animation: slideUp 0.5s ease;
            border: none;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .nutri { color: #95cd41; font-weight: bold; }
        .plan  { color: #ea5c2b; font-weight: bold; }

        .logo-block {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.4rem;
            margin-bottom: 0.25rem;
        }

        .logo-img   { width: 40px; height: 40px; object-fit: contain; }
        .brand-name { font-size: 1.6rem; }

        .subtitle {
            color: #6B7280;
            font-size: 0.88rem;
            margin-bottom: 1.5rem;
            line-height: 1.5;
        }

        /* Icon envelope illustration */
        .envelope-icon {
            width: 72px;
            height: 72px;
            background: linear-gradient(135deg, #95cd41, #ea5c2b);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
            box-shadow: 0 6px 20px rgba(234,92,43,0.3);
        }

        .envelope-icon svg { width: 36px; height: 36px; }

        .form-label {
            font-size: 0.9rem;
            margin-bottom: 0.35rem;
        }

        .form-control {
            border-radius: 50px !important;
            padding: 0.5rem 1.1rem;
            font-size: 0.9rem;
            border: none;
            background: linear-gradient(90deg, #95cd41 0%, #ea5c2b 100%);
            color: white;
        }

        .form-control::placeholder { color: rgba(255,255,255,0.75); }

        .form-control:focus {
            box-shadow: 0 0 0 3px rgba(149,205,65,0.35);
            outline: none;
            background: linear-gradient(90deg, #95cd41 0%, #ea5c2b 100%);
            color: white;
        }

        .btn-ijo {
            border-radius: 50px;
            padding: 0.6rem;
            font-size: 1rem;
            border: none;
            color: white;
            background: linear-gradient(90deg, #95cd41 0%, #ea5c2b 100%);
            transition: opacity 0.25s ease, transform 0.2s ease;
            box-shadow: 0 4px 12px rgba(149,205,65,0.35);
        }

        .btn-ijo:hover {
            opacity: 0.88;
            color: white;
            transform: translateY(-1px);
        }

        .link-auth {
            color: #ea5c2b;
            text-decoration: none;
            font-weight: bold;
        }

        .footer-text { font-size: 0.88rem; color: #6B7280; }

        @media (max-width: 480px) {
            .card-auth { padding: 1.5rem 1.25rem; }
        }
    </style>
</head>

<body>

    <a href="{{ route('login') }}" class="back-btn">← Back</a>

    <div class="page-wrapper">
        <div class="card card-auth">

            {{-- Logo --}}
            <div class="logo-block">
                <img src="{{ asset('img/logo.png') }}" alt="NutriPlan Logo" class="logo-img">
                <span class="brand-name">
                    <span class="nutri">Nutri</span><span class="plan">Plan</span>
                </span>
            </div>

            {{-- Envelope Icon --}}
            <div class="envelope-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                    <polyline points="22,6 12,13 2,6"/>
                </svg>
            </div>

            <h4 class="text-center fw-bold mb-0" style="color:#ea5c2b;">Forgot Password?</h4>
            <p class="text-center subtitle mt-2">
                No worries! Enter your email and we'll send you a link to reset your password.
            </p>

            {{-- Flash Messages --}}
            @if (session('success'))
                <div class="alert alert-success py-2 text-center" style="border-radius:12px; font-size:0.88rem;">
                    ✅ {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger py-2 text-center" style="border-radius:12px; font-size:0.88rem;">
                    {{ $errors->first() }}
                </div>
            @endif

            {{-- Form --}}
            <form method="POST" action="{{ route('password.forgot.send') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label fw-semibold">Email Address</label>
                    <input
                        type="email"
                        name="email"
                        class="form-control @error('email') is-invalid @enderror"
                        placeholder="Enter your registered email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                    >
                    @error('email')
                        <div class="invalid-feedback ps-2">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-ijo w-100 fw-bold">
                    Send Reset Link
                </button>
            </form>

            <p class="text-center footer-text mt-3 mb-0">
                Remember your password?
                <a href="{{ route('login') }}" class="link-auth">Log In</a>
            </p>

        </div>
    </div>

</body>
</html>