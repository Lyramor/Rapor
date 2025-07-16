<?php

namespace App\Http\Controllers;

use App\Models\Modul;
use App\Models\RoleUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GateController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $userId = Auth::id();
        $user = User::find($userId);

        $moduls = $user->accessibleModuls();

        // return response()->json([
        //     'user' => $user,
        //     'moduls' => $moduls,
        // ]);

        return view('dashboard-menu.index', [
            'user' => $user,
            'moduls' => $moduls,
        ]);
    }

    // roleaccess
    public function showRole($modul_id)
    {
        $user_id = auth()->id();
        $user = User::find($user_id);

        $modul = Modul::find($modul_id);

        if (!$modul) {
            return response()->json(['error' => 'Modul not found'], 404);
        }

        // $accessibleRoles = $user->roles()->whereHas('moduls', function ($query) use ($modul_id) {
        //     $query->where('moduls.id', $modul_id);
        // })->get();
        $accessibleRoles =  $user->roleUser()
            ->whereHas('role', function ($query) use ($modul_id) {
                $query->whereHas('moduls', function ($query) use ($modul_id) {
                    $query->where('moduls.id', $modul_id);
                });
            })
            ->with(['role', 'unitkerja'])->get();

        return response()->json($accessibleRoles, 200);
    }

    // setRole
    public function setRole(Request $request)
    {
        // Mengambil user yang sedang login
        $user = Auth::user();

        // cek apakah request role sama dengan yang dimiliki data role user maka set session selected dengan role yang dipilih
        if ($user->roles->contains($request->role)) {
            // Set session selected_role dengan role yang dipilih
            $request->session()->put('selected_role', $user->roles->find($request->role)->name);
            $request->session()->put('selected_filter', $request->unitkerja);

            // Mengembalikan respons OK
            return response()->json(['message' => 'Session role berhasil diatur'], 200);
        } else {
            // Jika role yang dipilih tidak dimiliki user, kirim respons error
            return response()->json(['message' => 'Role tidak valid'], 403);
        }
    }
}
