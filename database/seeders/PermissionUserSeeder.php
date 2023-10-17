<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\User;
use Illuminate\Database\Seeder;

class PermissionUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Ambil beberapa user dan permission (sesuaikan dengan kebutuhan Anda)
        $users = User::limit(10)->get();
        $permissions = Permission::limit(7)->get();

        foreach ($users as $user) {
            if ($user->role->name == 'Administrator' || $user->role->name == 'Superuser') {
                $user->permissions()->attach($permissions->pluck('id'));
            } elseif ($user->role->name == 'User') {
                $user->permissions()->attach($permissions->pluck('id')->slice(5, 2));
            }
        }
    }
}
