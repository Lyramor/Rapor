<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class ProfileController extends Controller
{
    public function edit()
    {
        // Ambil data mahasiswa dari user yang sedang login
        $mahasiswa = Auth::user()->mahasiswa;

        // Tampilkan halaman edit profil
        return view('auth.changeprofile', compact('mahasiswa'));
    }

    public function update(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nim' => 'required|string|max:20',
            'jeniskelamin' => 'required',
            'agama' => 'required|string|max:50',
            'alamat' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'nohp' => 'nullable|string|max:20',
            'tanggallahir' => 'nullable|date',
            'tempatlahir' => 'nullable|string|max:100',
        ]);

        // Ambil data mahasiswa dari user yang sedang login
        $mahasiswa = Auth::user()->mahasiswa;

        // Update data mahasiswa
        $mahasiswa->update($validated);

        // Redirect kembali dengan pesan sukses
        return redirect()->route('profile.edit')->with('message', 'Profil berhasil diperbarui.');
    }
}
