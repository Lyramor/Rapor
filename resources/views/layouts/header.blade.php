<div class="header">
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="">
                <div class="header-content">
                    <div class="image-wrapper" style="float: left">
                        {{-- <img src="https://api-frontend.kemdikbud.go.id/v2/detail_pt_logo/MEFBMzk4QTItNkM2OC00RUUwLTg2RkEtM0VBNjVCNTREQzk3"> --}}
                        <img src="{{ asset('storage/images/unpas-logo.png') }}">
                    </div>
                    <div class="judul-app" style="float: left">
                        <h5>Sistem Terintegrasi</h5>
                        <p><strong>UNIVERSITAS PASUNDAN</strong></p>
                    </div>

                    <div class="button-app" style="float: right">
                        <a href="{{ route('profile.edit') }}" style="text-decoration: none" class="exit-button">Hello,
                            @if (Auth::check())
                                {{ Auth::user()->name }}
                            @endif
                        </a>
                        {{-- <a href="{{ route('changePasswordSecond') }}" style="text-decoration: none"
                            class="exit-button">Ganti Password</a> --}}
                        {{-- to gate --}}
                        <a href="{{ url('/gate') }}" style="text-decoration: none" class="exit-button">Menu</a>
                        {{-- to logout --}}
                        <form action="{{ url('/login/exit') }}" method="post">
                            @csrf
                            <button type="submit" class="exit-button">Keluar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
