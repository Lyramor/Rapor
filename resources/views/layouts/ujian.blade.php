<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="img/png" href="{{ asset('storage/images/favicon.jpeg') }}" sizes="16x16" />
    <!-- Bootstrap CSS -->
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <title>Sistem Terintegrasi Universitas Pasundan</title>
    <link rel="stylesheet" href="{{ asset('css/modul.css') }}">
    @yield('css-tambahan') <!-- Yield css tambahan -->
</head>

<body>
    @include('layouts.header-ujian') <!-- Include header -->
    {{-- @include('layouts.navbar') <!-- Include navbar --> --}}

    <div class="konten">
        @yield('konten') <!-- Yield kontent -->
    </div>

    {{-- @include('layouts.footer') <!-- Include footer --> --}}


    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script> --}}

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
    </script>
    -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // make it as accordion for smaller screens
            if (window.innerWidth < 992) {

                // close all inner dropdowns when parent is closed
                document.querySelectorAll('.navbar .dropdown').forEach(function(everydropdown) {
                    everydropdown.addEventListener('hidden.bs.dropdown', function() {
                        // after dropdown is hidden, then find all submenus
                        this.querySelectorAll('.submenu').forEach(function(everysubmenu) {
                            // hide every submenu as well
                            everysubmenu.style.display = 'none';
                        });
                    })
                });

                document.querySelectorAll('.dropdown-menu a').forEach(function(element) {
                    element.addEventListener('click', function(e) {
                        let nextEl = this.nextElementSibling;
                        if (nextEl && nextEl.classList.contains('submenu')) {
                            // prevent opening link if link needs to open dropdown
                            e.preventDefault();
                            if (nextEl.style.display == 'block') {
                                nextEl.style.display = 'none';
                            } else {
                                nextEl.style.display = 'block';
                            }

                        }
                    });
                })
            }
            // end if innerWidth
        });
        // DOMContentLoaded  end
    </script>

    @yield('js-tambahan') <!-- Yield js tambahan -->
</body>

</html>
