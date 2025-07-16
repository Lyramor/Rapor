<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function verify(Request $request)
    {
        // if (Auth::check()) {
        //     return redirect('/gate');
        // }

        // $credentials = $request->only('email', 'password');

        // if (Auth::attempt($credentials)) {
        //     $request->session()->regenerate();
        //     // Authentication passed...
        //     return redirect()->intended('/gate');
        // }

        // Coba autentikasi berdasarkan username
        $username = $request->input('email');
        $user = User::where('username', $username)
            ->orWhere('email', $username)
            ->first();

        // return response()->json($user);

        if ($user && Auth::attempt(['email' => $user->email, 'password' => $request->input('password')])) {
            // $request->session()->regenerate();
            if (!$request->session()->has('last_login')) {
                $request->session()->put('last_login', now());
                $request->session()->regenerate(); // Regenerasi hanya jika sesi kosong
            }
            // Authentication passed...
            if ($user->is_default_password) {
                return redirect()->route('changePassword');
            }
            return redirect()->intended('/gate');
        }

        return back()->withErrors([
            'email' => 'Email atau password tidak sesuai.',
        ]);
    }

    function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }

    function ApiVerify(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Jika validasi gagal, kirim respons dengan pesan error
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 422);
        }

        // Coba melakukan autentikasi
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            // Jika autentikasi berhasil, buat token untuk pengguna
            $user = Auth::user();
            $token = $user->createToken('Personal Access Token')->accessToken;

            // Kirim respons dengan token bearer
            return response()->json(['token' => $token], 200);
        } else {
            // Jika autentikasi gagal, kirim respons dengan pesan error
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }

    // changepassword
    public function changePassword()
    {
        return view('auth.changepassword');
    }

    // changepassword
    public function changePasswordSecond()
    {
        return view('auth.changepasswordsecond');
    }

    // updatePassword
    public function updatePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'password' => 'required|confirmed|min:8',
        ]);

        $user = Auth::user();

        // Periksa apakah password lama cocok
        if (!Hash::check($request->old_password, $user->password)) {
            return redirect()->back()->with('message', 'Password lama tidak cocok.');
        }

        // Update password baru
        $user->password = Hash::make($request->password);
        $user->is_default_password = false; // tandai bahwa password sudah diubah
        $user->save();

        // Kirim respons dengan pesan sukses
        return redirect('/gate');
    }

    // forgotpassword
    public function forgotPassword()
    {
        return view('auth.forgotpassword');
    }

    public function resetPassword(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|email',
            'dob' => 'required|date',
        ]);

        // Cari user berdasarkan email
        $user = User::where('email', $request->email)->first();

        // Cek apakah email ada di database & ambil tanggal lahir
        if ($user) {
            $dobFromDatabase = null;

            if ($user->pegawai) {
                $dobFromDatabase = $user->pegawai->tanggallahir; // Sesuai dengan nama field di model Pegawai
            } elseif ($user->mahasiswa) {
                $dobFromDatabase = $user->mahasiswa->tanggallahir; // Sesuai dengan nama field di model Mahasiswa
            }

            // Jika tanggal lahir tidak cocok atau tidak ditemukan, tetap beri response yang sama
            if (!$dobFromDatabase || $dobFromDatabase != Carbon::parse($request->dob)->format('Y-m-d')) {
                return back()->with('error', 'Email atau tanggal lahir tidak sesuai.');
            }

            // Buat password acak baru
            $newPassword = Str::random(12);

            // Simpan password baru di database
            $user->update([
                'password' => Hash::make($newPassword),
                'is_default_password' => true
            ]);

            // // Kirim email berisi password baru
            Mail::send('auth.resetpassword', ['user' => $user, 'password' => $newPassword], function ($message) use ($user) {
                $message->to($user->email)
                        ->subject('Reset Password Berhasil - Universitas Pasundan')
                        ->from('stafwadek1ft@unpas.ac.id', 'Universitas Pasundan');
            });

            // return view('auth.show_new_password', ['newPassword' => $newPassword]);
        }

        // Tetap berikan response yang sama untuk semua kasus
        return back()->with('status', 'Jika email dan tanggal lahir sesuai, password baru telah dikirim ke email Anda.');
    }

    // public function resetPassword(Request $request)
    // {
    //     // Validasi input
    //     $request->validate([
    //         'email' => 'required|email',
    //         'dob' => 'required|date',
    //     ]);

    //     // Cari user berdasarkan email
    //     $user = User::where('email', $request->email)->first();

    //     if ($user) {
    //         // Cek tanggal lahir dari Pegawai atau Mahasiswa
    //         $dobFromDatabase = null;

    //         if ($user->pegawai) {
    //             $dobFromDatabase = $user->pegawai->tanggallahir;
    //         } elseif ($user->mahasiswa) {
    //             $dobFromDatabase = $user->mahasiswa->tanggallahir;
    //         }

    //         // Jika tanggal lahir tidak cocok atau tidak ditemukan, tampilkan pesan error yang sama
    //         if (!$dobFromDatabase || $dobFromDatabase != Carbon::parse($request->dob)->format('Y-m-d')) {
    //             return back()->with('error', 'Email atau tanggal lahir tidak sesuai.');
    //         }

    //         // Buat password acak baru
    //         $newPassword = Str::random(12);

    //         // Simpan password baru di database & tandai sebagai default password
    //         $user->update([
    //             'password' => Hash::make($newPassword),
    //             'is_default_password' => true
    //         ]);

    //         // Redirect ke halaman tampilan password baru
    //         return view('auth.newpassword', ['newPassword' => $newPassword]);
    //     }

    //     // Jika email tidak ditemukan, tetap berikan response yang sama
    //     return back()->with('error', 'Email atau tanggal lahir tidak sesuai.');
        
    // }
}
