<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $login = $request->input('login');
        $password = $request->input('password');

        $fieldType = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $credentials = [
            $fieldType => $login,
            'password' => $password,
        ];

        if (!$token = auth()->attempt($credentials)) {
            return response()->json([
                'error' => 'Unauthorized',
                'message' => 'Username/email atau password salah.'
            ], 401);
        }

        $user = auth()->user();

        // Cek apakah user adalah pegawai atau mahasiswa
        $relationData = null;
        $type = null;

        if ($user->pegawai) {
            $type = 'pegawai';
             // Konversi model pegawai ke array
            $pegawai = $user->pegawai->toArray();

            // Tambahkan nama unit dari relasi unitKerja
            $pegawai['unit_kerja'] = [
                'id' => $user->pegawai->unitKerja->id ?? null,
                'nama_unit' => $user->pegawai->unitKerja->nama_unit ?? null,
            ];

            $relationData = $pegawai;
            // $relationData = $user->pegawai;
            // $relationData = [
            //     'nama' => $user->pegawai->nama,
            //     'nip' => $user->pegawai->nip,
            //     'jabatan' => $user->pegawai->jabatanstruktural,
            //     'unit_kerja' => [
            //         'id' => $user->pegawai->unitKerja->id ?? null,
            //         'nama_unit' => $user->pegawai->unitKerja->nama_unit ?? null
            //     ]
            // ];
        } elseif ($user->mahasiswa) {
            $type = 'mahasiswa';
            $relationData = $user->mahasiswa;
        }

        // Ambil role (jika perlu)
        $roles = $user->roles->pluck('name');

        return response()->json([
            'token' => $token,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'username' => $user->username,
                'type' => $type,
                'relation' => $relationData,
                'roles' => $roles,
            ],
        ]);
    }
}
