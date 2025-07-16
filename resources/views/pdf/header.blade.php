<!DOCTYPE html>
<html>

<head>
    <title>Header</title>
    <style>
        /* Gaya CSS untuk header */
        header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 50px;
            /* Sesuaikan tinggi header Anda */
            /* background-color: #f2f2f2; */
            text-align: center;
        }
    </style>
</head>

<body>
    <header>
        {{-- <p>Ini adalah header</p> --}}
        <img src="{{ public_path('storage/images/Kop-FT.png') }}" style="width: 100%" alt="Logo" class="logo">
    </header>
</body>

</html>
