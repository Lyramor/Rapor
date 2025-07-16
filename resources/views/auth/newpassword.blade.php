<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Baru</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('{{ asset('storage/images/bg-pattern.png') }}');
            background-repeat: repeat;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }

        .password-container {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            width: 100%;
            padding: 40px;
            text-align: center;
        }

        .password-container h2 {
            margin-bottom: 20px;
        }

        .password-container p {
            font-size: 16px;
            color: #555;
            margin-bottom: 20px;
        }

        .password-box {
            font-size: 24px;
            font-weight: bold;
            background: #f8f9fa;
            padding: 10px;
            border-radius: 5px;
            display: inline-block;
            margin-bottom: 20px;
            word-break: break-all;
        }

        .btn-copy {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn-copy:hover {
            background-color: #0056b3;
        }

        .back-to-login {
            margin-top: 20px;
        }

        .back-to-login a {
            color: #007bff;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div class="password-container">
        <h2>Password Baru Anda</h2>
        <p>Silakan simpan password ini dengan aman. Gunakan untuk login ke akun Anda dan segera ubah password.</p>

        <div class="password-box" id="password">{{ $newPassword }}</div>
        <br>
        <button class="btn-copy" onclick="copyPassword()">Salin Password</button>

        <div class="back-to-login">
            <a href="{{ url('login') }}">Kembali ke Login</a>
        </div>
    </div>

    <script>
        function copyPassword() {
            var passwordText = document.getElementById("password").innerText;
            navigator.clipboard.writeText(passwordText);
            alert("Password telah disalin ke clipboard!");
        }
    </script>
</body>

</html>