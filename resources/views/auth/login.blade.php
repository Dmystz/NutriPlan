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
        .plan { color: #ea5c2b; font-weight: bold; }

        .btn-ijo {
            background-color: #95cd41;
            color: white;
            border-radius: 50px;
        }

        .btn-ijo:hover {
            background-color: #6e9c29;
        }

        .link-auth {
            color: #ea5c2b;
            text-decoration: none;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="d-flex justify-content-center align-items-center vh-100">
    <div class="card card-auth p-4">

        <h3 class="text-center mb-4">
            <span class="nutri">Nutri</span><span class="plan">Plan</span>
        </h3>

        <h5 class="text-center mb-3">Welcome Back</h5>

        <form>
            <div class="mb-3">
                <label>Email</label>
                <input type="email" class="form-control rounded-pill">
            </div>

            <div class="mb-3">
                <label>Password</label>
                <input type="password" class="form-control rounded-pill">
            </div>

            <button class="btn btn-ijo w-100 mt-3">Login</button>
        </form>

        <p class="text-center mt-3">
            Don't have an account?
            <a href="{{ route('register') }}" class="link-auth">Sign Up</a>
        </p>

    </div>
</div>

</body>
</html>
