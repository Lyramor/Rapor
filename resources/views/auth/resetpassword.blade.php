<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Reset Password - Universitas Pasundan</title>
</head>
<body>
    <p>Halo, {{ $user->name }}</p>
    <p>Password Anda telah direset. Silakan gunakan password baru berikut untuk login:</p>

    <h2>{{ $password }}</h2>

    <p>Harap segera ganti password setelah login untuk menjaga keamanan akun Anda.</p>

    <p>Salam,</p>
    <p><strong>Universitas Pasundan</strong></p>
</body>
</html>
