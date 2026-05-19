<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: "SF Pro Display", -apple-system, Arial, sans-serif;
            background: #f9fafb;
            margin: 0;
            padding: 0;
        }
        .wrapper {
            max-width: 520px;
            margin: 40px auto;
            background: #fff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        }
        .header {
            background: linear-gradient(135deg, #95cd41, #ea5c2b);
            padding: 32px 24px;
            text-align: center;
        }
        .header h1 {
            color: white;
            font-size: 26px;
            margin: 0;
            letter-spacing: -0.5px;
        }
        .header p {
            color: rgba(255,255,255,0.85);
            margin: 4px 0 0;
            font-size: 14px;
        }
        .body {
            padding: 32px 32px 24px;
        }
        .body p {
            color: #374151;
            font-size: 15px;
            line-height: 1.7;
            margin: 0 0 16px;
        }
        .btn-reset {
            display: inline-block;
            padding: 14px 32px;
            background: linear-gradient(90deg, #95cd41, #ea5c2b);
            color: white !important;
            border-radius: 50px;
            text-decoration: none;
            font-weight: bold;
            font-size: 15px;
            margin: 8px 0 20px;
        }
        .note {
            background: #fef9f0;
            border-left: 4px solid #ea5c2b;
            border-radius: 8px;
            padding: 12px 16px;
            font-size: 13px;
            color: #6B7280;
        }
        .footer {
            text-align: center;
            padding: 20px 24px;
            font-size: 12px;
            color: #9CA3AF;
            border-top: 1px solid #F3F4F6;
        }
        .footer span { color: #95cd41; font-weight: bold; }
        .footer span + span { color: #ea5c2b; }
    </style>
</head>
<body>
<div class="wrapper">
    <div class="header">
        <h1>🥗 <span style="color:#fff;">Nutri</span><span style="color:#ffd8df;">Plan</span></h1>
        <p>Your healthy journey companion</p>
    </div>
    <div class="body">
        <p>Hi <strong>{{ $user->name }}</strong>,</p>
        <p>
            We received a request to reset the password for your NutriPlan account.
            Click the button below to choose a new password. This link will expire in <strong>60 minutes</strong>.
        </p>

        <div style="text-align:center;">
            <a href="{{ $resetUrl }}" class="btn-reset">Reset My Password</a>
        </div>

        <div class="note">
            ⚠️ If you didn't request a password reset, you can safely ignore this email.
            Your password will remain unchanged.
        </div>

        <p style="margin-top:20px; font-size:13px; color:#9CA3AF;">
            Or copy and paste this URL into your browser:<br>
            <a href="{{ $resetUrl }}" style="color:#ea5c2b; word-break:break-all;">{{ $resetUrl }}</a>
        </p>
    </div>
    <div class="footer">
        © {{ date('Y') }} <span>Nutri</span><span>Plan</span>. All rights reserved.
    </div>
</div>
</body>
</html>