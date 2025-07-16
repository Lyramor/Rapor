<!DOCTYPE html>
<html>

<head>
    <title>Document</title>
    <style>
        /* Gaya CSS Anda bisa dimasukkan di sini */
        .content {
            /* background-color: aqua; */
            margin: 80px 30px 60px 30px;
        }

        h1,
        h2,
        h3,
        h4 {
            text-align: center;
            line-height: 0.5;
        }

        .table-rapor {
            border: 1px solid black;
            border-collapse: collapse;
            width: 100%;
            margin-top: 15px;
            line-height: 0.7;
        }

        .table-rapor th {
            border: 1px solid black;
            text-align: center;
            padding: 10px auto;
        }

        .table-rapor td {
            border: 1px solid black;
            padding: 8px;
        }

        .kolom-nomor {
            width: 10px;
        }

        .kolom-tengah {
            text-align: center;
            padding: 3px auto;
            width: 150px;
        }
    </style>
</head>

<body>
    {{-- @include('pdf.header') <!-- Include header --> --}}
    <div class="content">
        <!-- Konten utama halaman akan dimuat di sini -->
        @yield('content')
    </div>
    @include('pdf.footer') <!-- Include footer -->
</body>

</html>
