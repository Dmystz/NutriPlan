<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('img/logo.png') }}">
    <title>Reset Password - NutriPlan</title>
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
            max-width: 420px;
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

        /* Lock icon */
        .lock-icon {
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

        .lock-icon svg { width: 36px; height: 36px; }

        .subtitle {
            color: #6B7280;
            font-size: 0.88rem;
            margin-bottom: 1.5rem;
            line-height: 1.5;
        }

        .form-label {
            font-size: 0.9rem;
            margin-bottom: 0.35rem;
        }

        /* Password field wrapper for show/hide toggle */
        .password-wrapper {
            position: relative;
        }

        .form-control {
            border-radius: 50px !important;
            padding: 0.5rem 2.8rem 0.5rem 1.1rem;
            font-size: 0.9rem;
            border: none;
            background: linear-gradient(90deg, #95cd41 0%, #ea5c2b 100%);
            color: white;
            width: 100%;
        }

        .form-control::placeholder { color: rgba(255,255,255,0.75); }

        .form-control:focus {
            box-shadow: 0 0 0 3px rgba(149,205,65,0.35);
            outline: none;
            background: linear-gradient(90deg, #95cd41 0%, #ea5c2b 100%);
            color: white;
        }

        /* Show/hide password toggle */
        .toggle-pw {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: rgba(255,255,255,0.85);
            background: none;
            border: none;
            padding: 0;
            line-height: 1;
        }

        .toggle-pw:hover { color: white; }

        /* Password strength bar */
        .strength-bar-wrap {
            height: 4px;
            background: #E5E7EB;
            border-radius: 99px;
            margin-top: 6px;
            overflow: hidden;
        }

        .strength-bar {
            height: 100%;
            width: 0%;
            border-radius: 99px;
            transition: width 0.3s ease, background 0.3s ease;
        }

        .strength-label {
            font-size: 0.75rem;
            margin-top: 3px;
            color: #6B7280;
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

            {{-- Lock icon --}}
            <div class="lock-icon">
                <svg viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                    <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                </svg>
            </div>

            <h4 class="text-center fw-bold mb-0" style="color:#ea5c2b;">Set New Password</h4>
            <p class="text-center subtitle mt-2">
                Create a strong password for your NutriPlan account.
            </p>

            {{-- Flash / Error Messages --}}
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
            <form method="POST" action="{{ route('password.reset.process') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <input type="hidden" name="email" value="{{ $email }}">

                {{-- New Password --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">New Password</label>
                    <div class="password-wrapper">
                        <input
                            type="password"
                            name="password"
                            id="pw1"
                            class="form-control @error('password') is-invalid @enderror"
                            placeholder="Minimum 8 characters"
                            required
                            autofocus
                            oninput="checkStrength(this.value)"
                        >
                        <button type="button" class="toggle-pw" onclick="togglePw('pw1', this)">
                            <svg id="eye1" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                        </button>
                    </div>
                    {{-- Strength bar --}}
                    <div class="strength-bar-wrap">
                        <div class="strength-bar" id="strengthBar"></div>
                    </div>
                    <div class="strength-label" id="strengthLabel"></div>
                    @error('password')
                        <div class="invalid-feedback ps-2 d-block">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Confirm Password --}}
                <div class="mb-3">
                    <label class="form-label fw-semibold">Confirm Password</label>
                    <div class="password-wrapper">
                        <input
                            type="password"
                            name="password_confirmation"
                            id="pw2"
                            class="form-control"
                            placeholder="Re-enter your password"
                            required
                        >
                        <button type="button" class="toggle-pw" onclick="togglePw('pw2', this)">
                            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn btn-ijo w-100 fw-bold mt-1">
                    Reset Password
                </button>
            </form>

            <p class="text-center footer-text mt-3 mb-0">
                Back to <a href="{{ route('login') }}" class="link-auth">Log In</a>
            </p>

        </div>
    </div>

    <script>
        // Toggle show/hide password
        function togglePw(inputId, btn) {
            const input = document.getElementById(inputId);
            const isPassword = input.type === 'password';
            input.type = isPassword ? 'text' : 'password';
            // Swap icon
            btn.innerHTML = isPassword
                ? `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/>
                        <path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/>
                        <line x1="1" y1="1" x2="23" y2="23"/>
                   </svg>`
                : `<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                        <circle cx="12" cy="12" r="3"/>
                   </svg>`;
        }

        // Password strength indicator
        function checkStrength(pw) {
            const bar   = document.getElementById('strengthBar');
            const label = document.getElementById('strengthLabel');

            let score = 0;
            if (pw.length >= 8)              score++;
            if (/[A-Z]/.test(pw))            score++;
            if (/[0-9]/.test(pw))            score++;
            if (/[^A-Za-z0-9]/.test(pw))     score++;

            const levels = [
                { pct: '0%',   color: '#E5E7EB', text: '' },
                { pct: '25%',  color: '#ef4444', text: 'Weak' },
                { pct: '50%',  color: '#f97316', text: 'Fair' },
                { pct: '75%',  color: '#eab308', text: 'Good' },
                { pct: '100%', color: '#22c55e', text: 'Strong 💪' },
            ];

            const lvl = pw.length === 0 ? levels[0] : levels[score];
            bar.style.width      = lvl.pct;
            bar.style.background = lvl.color;
            label.textContent    = lvl.text;
            label.style.color    = lvl.color;
        }
    </script>

</body>
</html>