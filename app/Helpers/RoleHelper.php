<?php

// Buat file app/Helpers/RoleHelper.php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;

class RoleHelper
{
    /**
     * Cek apakah role adalah Admin PPKPT
     */
    public static function isAdminPPKT($role = null)
    {
        $selectedRole = $role ?? session('selected_role');
        
        // Daftar kemungkinan nama role Admin PPKPT
        $adminPPKTRoles = [
            'Admin PPKPT Fakultas',
            'Admin PPKPT Prodi',
            'Admin PPKT Fakultas',  // Kemungkinan typo
            'Admin PPKT Prodi',     // Kemungkinan typo
            'PPKPT Admin Fakultas', // Kemungkinan variasi
            'PPKPT Admin Prodi',    // Kemungkinan variasi
        ];
        
        // Cek exact match
        if (in_array($selectedRole, $adminPPKTRoles)) {
            return true;
        }
        
        // Cek dengan case insensitive
        $selectedRoleLower = strtolower($selectedRole);
        foreach ($adminPPKTRoles as $adminRole) {
            if (strtolower($adminRole) === $selectedRoleLower) {
                return true;
            }
        }
        
        // Cek dengan contains
        if (str_contains($selectedRoleLower, 'ppkpt') || str_contains($selectedRoleLower, 'ppkt')) {
            if (str_contains($selectedRoleLower, 'admin') || str_contains($selectedRoleLower, 'administrator')) {
                return true;
            }
        }
        
        return false;
    }
    
    /**
     * Dapatkan semua role yang tersedia untuk user
     */
    public static function getAllUserRoles($userId = null)
    {
        $userId = $userId ?? auth()->id();
        
        // Query untuk mendapatkan semua role user
        // Sesuaikan dengan struktur database Anda
        $roles = DB::table('role_user')
            ->join('roles', 'role_user.role_id', '=', 'roles.id')
            ->where('role_user.user_id', $userId)
            ->pluck('roles.name')
            ->toArray();
            
        return $roles;
    }
}