<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Pegawai;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class GenerateUserFromPegawai extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:generate-user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */

    public function __construct()
    {
        parent::__construct();
    }


    public function handle()
    {
        // where jenispegawai != 'Tendik'

        $pegawais = Pegawai::whereDoesntHave('user')
            // ->where('jenispegawai', '==', 'Pegawai')
            // ->where('jenispegawai', 'Pegawai')
            ->get();

        foreach ($pegawais as $pegawai) {
            // Username adalah NIP
            $username = $pegawai->nip;

            // Cek apakah email sudah digunakan, jika sudah tambahkan suffix unik
            $email = $pegawai->email;

            // check jika email null
            if ($email == null) {
                $email = $pegawai->nip . "@unpas.ac.id";
            }

            $emailExists = User::where('email', $email)->exists();
            if ($emailExists) {
                $email = $pegawai->nip . rand(1, 10) . "@unpas.ac.id";
            }

            // Password default
            $password = 'Pasundan2024'; // Ganti dengan password default yang diinginkan

            // Buat user baru
            $user = User::create([
                'name' => $pegawai->nama,
                'email' => $email,
                'username' => $username,
                'password' => Hash::make($password),
                'key_relation' => $pegawai->nip,
            ]);

            $this->info('User ' . $pegawai->nama . ' berhasil dibuat.');
            $this->info('User ' . $user->name . ' berhasil dibuat.');
            // Hubungkan user dengan pegawai
            $pegawai->user()->save($user);
        }

        $this->info('User berhasil dibuat dari data pegawai.');
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
