<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ResetAllPasswords extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:reset-all-passwords';

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
        $defaultPassword = 'Pasundan2024'; // Ganti dengan password default yang diinginkan

        // Ambil semua pengguna
        $users = User::whereHas('pegawai')->get();

        foreach ($users as $user) {
            // Reset password
            $user->password = Hash::make($defaultPassword);
            $user->save();
            $this->info("Password for user {$user->username} has been reset.");
        }

        $this->info('All user passwords have been reset.');
    }
}
