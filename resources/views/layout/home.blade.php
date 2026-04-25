<!DOCTYPE html>
<html>
<head>
    <title>Home</title>
</head>
<body>

    <h1>Selamat datang, {{ session('user_name') }}</h1>

    <a href="/logout">Logout</a>

</body>
</html>