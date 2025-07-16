<!DOCTYPE html>
<html>
<head>
    <title>Footer</title>
    <style>
        /* Gaya CSS untuk footer */
        footer {
            position: fixed;
            z-index: 99999;
            bottom: -50px;
            left: 0;
            right: 0;
            height: 50px; /* Sesuaikan tinggi footer Anda */
            /* background-color: #f2f2f2; */
            text-align: center;
        }
    </style>
</head>
<body>
    <footer>
        {{-- <p>Ini adalah footer</p> --}}
        <img src="{{ public_path('storage/images/footer-ft.png') }}" style="width: 100%" alt="Logo" class="logo">
    </footer>
</body>
</html>
