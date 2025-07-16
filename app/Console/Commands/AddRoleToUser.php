<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Role;
use App\Models\User;
use App\Models\RoleUser;

class AddRoleToUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:add-role-to-user';

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
        $pegawaiRole = Role::firstOrCreate(['name' => 'Pegawai']);
        $adminRole = Role::firstOrCreate(['name' => 'Admin']);

        // Looping through users
        User::each(function ($user) use ($pegawaiRole, $adminRole) {
            // Create RoleUser for Pegawai Role
            RoleUser::firstOrCreate([
                'user_id' => $user->id,
                'role_id' => $pegawaiRole->id,
            ]);

            // Create RoleUser for Admin Role if username is "IF397"
            if ($user->username === 'IF397') {
                RoleUser::firstOrCreate([
                    'user_id' => $user->id,
                    'role_id' => $adminRole->id,
                ]);
            }
        });

        $this->info('Roles assigned successfully.');
    }
}
