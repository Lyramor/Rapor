<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Profil</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('{{ asset('storage/images/bg-pattern.png') }}');
            background-repeat: repeat;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
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

        .profile-container {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            max-width: 1000px;
            width: 100%;
            padding: 40px;
            margin: 40px 0;
        }
    </style>
</head>

<body>
    <div class="profile-container">
        <h2>Ubah Profil</h2>
        <p style="text-align: center">Perbarui informasi profil Anda di sini.</p>

        @if (session('message'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">X</button>
            </div>
        @endif

        <form method="POST" action="{{ route('profile.update') }}">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="nama">Nama Lengkap</label>
                        <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama"
                            name="nama" value="{{ old('nama', $mahasiswa->nama) }}" required>
                        @error('nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="nim">NIM</label>
                        <input type="text" class="form-control @error('nim') is-invalid @enderror" id="nim"
                            name="nim" value="{{ old('nim', $mahasiswa->nim) }}" required readonly>
                        @error('nim')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="jeniskelamin">Jenis Kelamin</label>
                        <select class="form-control @error('jeniskelamin') is-invalid @enderror" id="jeniskelamin"
                            name="jeniskelamin" required>
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="L"
                                {{ old('jeniskelamin', $mahasiswa->jeniskelamin) == 'L' ? 'selected' : '' }}>
                                Laki-laki
                            </option>
                            <option value="P"
                                {{ old('jeniskelamin', $mahasiswa->jeniskelamin) == 'P' ? 'selected' : '' }}>
                                Perempuan
                            </option>
                        </select>
                        @error('jeniskelamin')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="agama">Agama</label>
                        <input type="text" class="form-control @error('agama') is-invalid @enderror" id="agama"
                            name="agama" value="{{ old('agama', $mahasiswa->agama) }}" required>
                        @error('agama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <input type="text" class="form-control @error('alamat') is-invalid @enderror" id="alamat"
                            name="alamat" value="{{ old('alamat', $mahasiswa->alamat) }}">
                        @error('alamat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                            name="email" value="{{ old('email', $mahasiswa->email) }}">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="nohp">Nomor HP</label>
                        <input type="text" class="form-control @error('nohp') is-invalid @enderror" id="nohp"
                            name="nohp" value="{{ old('nohp', $mahasiswa->nohp) }}">
                        @error('nohp')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="tanggallahir">Tanggal Lahir</label>
                        <input type="date" class="form-control @error('tanggallahir') is-invalid @enderror"
                            id="tanggallahir" name="tanggallahir"
                            value="{{ old('tanggallahir', $mahasiswa->tanggallahir) }}">
                        @error('tanggallahir')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="tempatlahir">Tempat Lahir</label>
                        <input type="text" class="form-control @error('tempatlahir') is-invalid @enderror"
                            id="tempatlahir" name="tempatlahir"
                            value="{{ old('tempatlahir', $mahasiswa->tempatlahir) }}">
                        @error('tempatlahir')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-12">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('gate') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </div>
        </form>
    </div>
</body>

</html>
