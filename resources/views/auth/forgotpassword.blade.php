<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password</title>
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

        body::before {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.1);
            z-index: -1;
        }

        .forgot-container {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            max-width: 1000px;
            width: 100%;
            display: flex;
            padding: 0;
            height: 550px;
            position: relative;
        }

        .forgot-left {
            flex: 1;
            padding-right: 40px;
            margin-right: -40px;
            background: url('{{ asset('storage/images/login-side-left.jpg') }}') no-repeat center center;
            background-size: cover;
            border-radius: 10px 0 0 10px;
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            color: white;
            padding-left: 20px;
        }

        .forgot-left h1 {
            font-size: 24px;
            font-weight: bold;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.5);
            text-decoration: underline;
            margin-bottom: 10px;
        }

        .forgot-left p {
            font-size: 18px;
            font-weight: bold;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.5);
            white-space: pre-line;
        }

        .forgot-right {
            flex: 1;
            padding-left: 40px;
            margin: 20px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .forgot-right form {
            max-width: 400px;
            width: 100%;
            margin: 0 auto;
        }

        .forgot-right form input[type="email"],
        .forgot-right form input[type="date"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: none;
            border-bottom: 0.1px solid #2f7be6;
            border-radius: 0;
            box-sizing: border-box;
        }

        .forgot-right form button[type="submit"] {
            width: 100%;
            padding: 12px;
            border-radius: 5px;
            border: none;
            background-color: #007bff;
            color: #fff;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .forgot-right form button[type="submit"]:hover {
            background-color: #0056b3;
        }

        .forgot-right .back-to-login {
            margin-top: 10px;
            text-align: center;
        }

        .forgot-right .back-to-login a {
            color: #007bff;
            text-decoration: none;
        }

        @media (max-width: 768px) {
            .forgot-container {
                flex-direction: column;
                height: auto;
            }

            .forgot-left {
                border-radius: 10px 10px 0 0;
                margin: 0;
            }

            .forgot-right {
                border-radius: 0 0 10px 10px;
                margin: 0;
            }
        }
    </style>
</head>

<body>
    <div class="forgot-container">
        <div class="forgot-left">
            <h1>Selamat Datang</h1>
            <p>LINK APP<br><strong>UNIVERSITAS PASUNDAN</strong></p>
        </div>
        <div class="forgot-right">
            <h2>Reset Password</h2>
            <p style="text-align: center">Masukkan email yang terkait dengan NIM atau NIP Anda serta tanggal lahir. Kami akan mengirimkan link untuk mereset password.</p>

            @if (session('status'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('status') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <form method="POST" action="{{ url('forgotpassword/request') }}">
                @csrf
                <div class="form-group">
                    <label for="email">Email SITU2</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                        placeholder="Masukkan email yang terkait dengan NIM atau NIP Anda" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="dob">Tanggal Lahir</label>
                    <input type="date" class="form-control @error('dob') is-invalid @enderror" name="dob" required>
                    @error('dob')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Kirim Link Reset</button>
            </form>

            <div class="back-to-login">
                <a href="{{ url('login') }}">Kembali ke Login</a>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>

</html>
