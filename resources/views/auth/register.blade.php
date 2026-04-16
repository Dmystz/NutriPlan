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
        .plan { color: #ea5c2b; font-weight: bold; }

        .btn-oren {
            background-color: #ea5c2b;
            color: white;
            border-radius: 50px;
        }

        .btn-oren:hover {
            background-color: #cd4c22;
        }

        .link-auth {
            color: #95cd41;
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

        <h5 class="text-center mb-3">Create Account</h5>

        <form>
            <div class="mb-3">
                <label>Name</label>
                <input type="text" class="form-control rounded-pill">
            </div>

            <div class="mb-3">
                <label>Email</label>
                <input type="email" class="form-control rounded-pill">
            </div>

            <div class="mb-3">
                <label>Password</label>
                <input type="password" class="form-control rounded-pill">
            </div>

            <button class="btn btn-oren w-100 mt-3">Sign Up</button>
        </form>

        <p class="text-center mt-3">
            Already have an account?
            <a href="{{ route('login') }}" class="link-auth">Login</a>
        </p>

    </div>
</div>

</body>
</html>