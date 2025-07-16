<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RoleUser;

class RoleUserController extends Controller
{
    // createRoleUser
    public function create(Request $request)
    {
        try {
            $request->validate([
                'user_id' => 'required',
                'role_id' => 'required',
                'unit_kerja_id' => 'required',
            ]);

            $roleUser = new RoleUser();
            $roleUser->user_id = $request->user_id;
            $roleUser->role_id = $request->role_id;
            $roleUser->unit_kerja_id = $request->unit_kerja_id;
            $roleUser->save();

            return response()->json(['message' => 'Data berhasil disimpan'], 200);
        } catch (\Exception $e) {
            // Jika terjadi kesalahan saat menyimpan data, kembalikan response error
            return response()->json(['message' => 'Gagal menyimpan data: ' . $e->getMessage()], 500);
        }
    }


    // delete
    public function delete($id)
    {
        try {
            // Temukan data soal kuesioner sdm yang akan dihapus
            $roleUser = RoleUser::find($id);

            // Data tidak ditemukan
            if (!$roleUser) {
                return response()->json(['message' => 'Data tidak ditemukan'], 404);
            }

            // Hapus data soal kuesioner sdm
            $roleUser->delete();

            // Kirim respon berhasil
            return response()->json(['message' => 'Data berhasil dihapus'], 200);
        } catch (\Exception $e) {
            //throw $th;
            return response()->json(['message' => 'Gagal Menghapus data: ' . $e->getMessage()], 500);
        }
    }
}
