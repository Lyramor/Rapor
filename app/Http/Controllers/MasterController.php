<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Modul;
use App\Models\Role;
use App\Models\User;
use App\Models\KuesionerSDM;
use App\Models\RoleModul;
use App\Models\SoalKuesionerSDM;
use App\Models\UnitKerja;
use App\Models\Pegawai;
use App\Models\RoleUser;
use Illuminate\Support\Facades\Hash;

class MasterController extends Controller
{
    // dashboard
    public function index()
    {
        return view('master.dashboard');
    }

    // modul
    public function modul()
    {
        // get data modul
        $moduls = Modul::all();
        return view('master.modul.index', [
            'moduls' => $moduls
        ]);
    }

    public function createModul()
    {
        $mode = 'tambah';

        return view('master.modul.create', [
            'mode' => $mode
        ]);
    }

    public function storeModul(Request $request)
    {
        try {
            // Validasi data yang dikirim
            $validatedData = $request->validate([
                'nama_modul' => 'required|string|max:255',
                'tautan' => 'required|string|max:255',
                'icon' => 'nullable|image|mimes:png,svg|max:2048',
                'urutan' => 'required|integer',
            ]);

            // Menghandle upload icon jika ada
            if ($request->hasFile('icon')) {
                $file = $request->file('icon');
                $iconName = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('path/to/icon'), $iconName);
                $validatedData['icon'] = $iconName;
            }

            // Simpan data modul baru
            Modul::create($validatedData);

            // Redirect dengan pesan sukses
            return redirect()->route('master.modul')->with('message', 'Modul berhasil ditambahkan');
        } catch (\Exception $e) {
            // Tangkap error dan tampilkan pesan error
            return redirect()->back()->withInput()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function editModul($id)
    {
        $mode = 'edit';
        $modul = Modul::find($id);

        return view('master.modul.create', [
            'mode' => $mode,
            'modul' => $modul
        ]);
    }

    public function updateModul(Request $request, $id)
    {
        try {
            // Validasi data yang dikirim
            $validatedData = $request->validate([
                'nama_modul' => 'required|string|max:255',
                'tautan' => 'required|string|max:255',
                'icon' => 'nullable|image|mimes:png,svg|max:2048',
                'urutan' => 'required|integer',
            ]);

            // Menghandle upload icon jika ada
            if ($request->hasFile('icon')) {
                $file = $request->file('icon');
                $iconName = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path('path/to/icon'), $iconName);
                $validatedData['icon'] = $iconName;
            }

            // Simpan data modul baru
            Modul::find($id)->update($validatedData);

            // Redirect dengan pesan sukses
            return redirect()->route('master.modul')->with('message', 'Modul berhasil diubah');
        } catch (\Exception $e) {
            // Tangkap error dan tampilkan pesan error
            return redirect()->back()->withInput()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function tambahRoleModul(Request $request)
    {
        // Validasi request
        $request->validate([
            'role_modul' => 'required|array',
            'role_id' => 'required',
        ]);

        try {
            // Ambil ID kuesioner SDM dari request
            $role_id = $request->role_id;

            // Ambil array dari role_modul yang dipilih
            $role_modul_ids = $request->role_modul;

            // Loop untuk setiap role_modul yang dipilih
            foreach ($role_modul_ids as $role_modul_id) {
                // Simpan data ke tabel pivot atau tabel relasi Many-to-Many
                RoleModul::create([
                    'role_id' => $role_id,
                    'modul_id' => $role_modul_id,
                ]);
            }

            return response()->json(['message' => 'Role Modul berhasil ditambahkan'], 200);
        } catch (\Exception $e) {
            // Tangani jika terjadi error
            return response()->json(['message' => $e], 500);
        }
    }

    public function destroyRoleModul($id)
    {
        try {
            // Temukan data responden yang akan dihapus
            $RoleModul = RoleModul::findOrFail($id);

            // Data tidak ditemukan
            if (!$RoleModul) {
                return response()->json(['message' => 'Data tidak ditemukan'], 404);
            }
            // Hapus data modul
            $RoleModul->delete();
            // Kirim respon berhasil
            return response()->json(['message' => 'Data berhasil dihapus'], 200);
        } catch (\Exception $e) {
            // Tangkap error dan tampilkan pesan error
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    // get data modul
    public function getModulData(Request $request)
    {
        $perPage = $request->has('limit') ? $request->get('limit') : 10;

        // $daftarPegawai  = Pegawai::with('unitKerja')->paginate(10);
        $daftarModul = Modul::when($request->has('search'), function ($query) use ($request) {
            $search = $request->get('search');
            $query->where('nama_modul', 'ilike', "%$search%");
        })->paginate($perPage);

        return response()->json($daftarModul);
    }

    // role
    public function role()
    {
        // get data role
        $roles = Role::all();
        return view('master.role.index', [
            'roles' => $roles
        ]);
    }

    public function createRole()
    {
        $mode = 'tambah';

        return view('master.role.create', [
            'mode' => $mode
        ]);
    }

    public function storeRole(Request $request)
    {
        try {
            // Validasi data yang dikirim
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'deskripsi' => 'required|string',
            ]);

            // Simpan data role baru
            Role::create($validatedData);

            // Redirect dengan pesan sukses
            return redirect()->route('master.role')->with('message', 'Role berhasil ditambahkan');
        } catch (\Exception $e) {
            // Tangkap error dan tampilkan pesan error
            return redirect()->back()->withInput()->with('message',  $e->getMessage());
            // return redirect()->back()->withInput()->withErrors(['message' => $e->getMessage()]);
        }
    }

    public function editRole($id)
    {
        $mode = 'edit';
        $role = Role::find($id);

        return view('master.role.create', [
            'mode' => $mode,
            'role' => $role
        ]);
    }

    public function updateRole(Request $request, $id)
    {
        // return 'update role';
    }

    //detail role
    public function showRole($id)
    {
        $role = Role::find($id);
        $moduls = RoleModul::with('modul')->where('role_id', $id)->get();

        // return response()->json($moduls);
        // $role = Role::find($id);

        return view('master.role.detail', [
            'data' => $role,
            'moduls' => $moduls,
        ]);
    }

    public function destroyRole($id)
    {
        try {
            // Hapus data modul
            Role::find($id)->delete();

            // Redirect dengan pesan sukses
            return redirect()->route('master.role')->with('message', 'Role berhasil dihapus');
        } catch (\Exception $e) {
            // Tangkap error dan tampilkan pesan error
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    //user
    public function user()
    {
        // get data role
        $users = User::paginate(10);
        $total = $users->total(); // Mendapatkan total data
        return view('master.user.index', [
            'data' => $users,
            'total' => $total
        ]);
    }

    public function createUser()
    {
        $mode = 'tambah';

        return view('master.user.create', [
            'mode' => $mode
        ]);
    }

    public function storeUser(Request $request)
    {
        try {
            // Validasi data yang dikirim
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:8',
                'role_id' => 'required|integer',
            ]);

            // Simpan data role baru
            User::create($validatedData);

            // Redirect dengan pesan sukses
            return redirect()->route('master.user')->with('message', 'User berhasil ditambahkan');
        } catch (\Exception $e) {
            // Tangkap error dan tampilkan pesan error
            return redirect()->back()->withInput()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function showUser($id)
    {
        $user = User::with(['pegawai', 'roleUser'])->find($id);
        // get unit kerja data order by name asc
        $unitkerja = UnitKerja::orderBy('nama_unit', 'asc')->get();

        $listrole = Role::all();

        $roleuser = RoleUser::with('unitkerja')->where('user_id', $id)->get();

        // return $user format json;
        // return response()->json($roleuser);


        return view('master.user.detail', [
            'data' => $user,
            'listrole' => $listrole,
            'unitkerja' => $unitkerja,
            'roleuser' => $roleuser
        ]);

        // return view('master.user.detail');
    }

    // unitkerja
    public function unitkerja()
    {
        // get data unit kerja
        $unitkerja = UnitKerja::with(['childUnit'])
            ->where('kode_unit', 'UNPAS')
            ->paginate(10);

        // return response()->json($unitkerja);
        $total = $unitkerja->total(); // Mendapatkan total data
        return view('master.unit-kerja.index', [
            'data' => $unitkerja,
            'total' => $total
        ]);
    }

    // pegawai
    public function pegawai()
    {
        // get data pegawai
        $pegawai = Pegawai::with('unitKerja')->paginate(10);
        $total = $pegawai->total(); // Mendapatkan total data
        // return response()->json($pegawai);
        return view('master.pegawai.index', [
            'data' => $pegawai,
            'total' => $total
        ]);
    }

    // sinkronasi
    public function sinkronasi()
    {
        return view('master.sinkronasi.index');
    }

    // resetPassword
    public function resetPassword(Request $request)
    {
        try {
            // validasi data yang dikirim
            $request->validate([
                'user_id' => 'required',
            ]);

            // Ambil data user berdasarkan ID
            $user = User::find($request->user_id);

            // Reset password user
            $user->password = Hash::make('Pasundan2024');
            $user->is_default_password = true;
            $user->save();
            // Reset password user using hash
            return response()->json(['message' => 'Password berhasil direset'], 200);
        } catch (\Exception $e) {
            // Tangkap error dan tampilkan pesan error
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
