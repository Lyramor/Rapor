<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    // getjsonkuesionersdm
    function getAllDataUser(Request $request)
    {
        // Menentukan jumlah data per halaman
        $perPage = $request->has('limit') ? $request->get('limit') : 10;

        // Mengambil data sesuai dengan request
        $users = User::when($request->has('search'), function ($query) use ($request) {
            $search = $request->get('search');
            $query->where(function ($query) use ($search) {
                $query->where('name', 'ilike', "%$search%")
                    ->orWhere('email', 'ilike', "%$search%")
                    ->orWhere('username', 'ilike', "%$search%");
            });
        })->paginate($perPage); // Menggunakan paginate untuk pagination

        return response()->json($users);
    }
}
