<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\RoleUser;
use App\Models\User;
use Illuminate\Support\Str;

class AssignPegawaiRole extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:assign-pegawai-role';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */

    protected $roleId = '9b9efc95-4915-45b5-864a-9bb611d0329a';
    
    public function handle()
    {
        // Ambil semua user yang memiliki relasi dengan Pegawai
        $users = User::whereHas('pegawai')->get();

        if ($users->isEmpty()) {
            $this->warn("Tidak ada user yang memiliki relasi dengan model Pegawai.");
            return;
        }

        $addedCount = 0;
        $updatedCount = 0;
        $skippedCount = 0;

        foreach ($users as $user) {
            $pegawai = $user->pegawai;

            // Cek apakah user sudah memiliki role Pegawai
            $roleUser = RoleUser::where('user_id', $user->id)
                ->where('role_id', $this->roleId)
                ->first();

            if ($roleUser) {
                if (is_null($roleUser->unit_kerja_id) && !is_null($pegawai->unit_kerja_id)) {
                    // Jika role_user sudah ada tetapi unit_kerja_id masih NULL, update nilainya
                    $roleUser->update([
                        'unit_kerja_id' => $pegawai->unit_kerja_id,
                    ]);

                    $updatedCount++;
                    $this->info("🔄 Unit kerja diperbarui untuk user {$user->name} (NIP: {$pegawai->nip}).");
                } else {
                    // Jika sudah memiliki role dan unit kerja valid, skip
                    $skippedCount++;
                }
                continue;
            }

            // Tambahkan role ke tabel role_user
            RoleUser::create([
                'id' => Str::uuid(),
                'user_id' => $user->id,
                'role_id' => $this->roleId,
                'unit_kerja_id' => $pegawai->unit_kerja_id,
            ]);

            $addedCount++;
            $this->info("✅ Role Pegawai berhasil ditambahkan ke user {$user->name} (NIP: {$pegawai->nip}).");
        }

        $this->info("\n📊 Laporan Eksekusi:");
        $this->info("✅ $addedCount user baru diberikan role Pegawai.");
        $this->info("🔄 $updatedCount user diperbarui unit_kerja_id-nya.");
        $this->info("⚠️ $skippedCount user sudah memiliki role dan unit kerja yang valid, tidak diubah.");
    }
}
