<?php

namespace App\Console\Commands;

use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class GenerateUserFromMahasiswa extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-mahasiswa';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $mhs = Mahasiswa::whereDoesntHave('user')
            ->where('statusmahasiswa', 'Aktif')
            ->where('periodemasuk', '20241')
            // ->where('programstudi', 'Ilmu Hukum')
            // ->where('nim', '203040106')
            // ->where('jenispegawai', 'Pegawai')
            ->get();

        if ($mhs->isEmpty()) {
            $this->info('Tidak ada data mahasiswa yang belum memiliki user.');
            return;
        }

        foreach ($mhs as $item) {
            // Username adalah NIP
            $username = $item->nim;

            // Cek apakah email sudah digunakan, jika sudah tambahkan suffix unik
            $email = $item->email;

            // check jika email null
            if ($email == null) {
                $email = $item->nim . "@mail.unpas.ac.id";
            }

            $emailExists = User::where('email', $email)->exists();
            if ($emailExists) {
                $email = $item->nim . rand(1, 10) . "@mail.unpas.ac.id";
            }

            // Password default dari tanggal lahir
            $password = date('dmY', strtotime($item->tanggallahir));

            // inforimasikan ke log ("Username: $username, Email: $email, Password: $password");
            // $this->info("Username: $username, Email: $email, Password: $password");

            // Buat user baru
            $user = User::create([
                'name' => $item->nama,
                'email' => $email,
                'username' => $username,
                'password' => Hash::make($password),
                'key_relation' => $item->nim,
            ]);

            $this->info("User {$user->name} berhasil dibuat.");

            // Hubungkan user dengan pegawai
            // $mhs->user()->save($user);
        }

        $this->info('User berhasil dibuat dari data mahasiswa.');
    }

    private function makeUniqueEmail($email)
    {
        $suffix = 1;
        while (User::where('email', $email)->exists()) {
            $email = $email . $suffix;
            $suffix++;
        }

        return $email;
    }
}
