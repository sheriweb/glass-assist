<?php

namespace Database\Seeders;

use App\Models\Enums\UserRoles;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'first_name' => 'Graeme',
            'surname' => 'Madden',
            'email' => 'gmadden@.com',
            'username' => 'gmadden',
            'password' => Hash::make('e4EGemUTav'),
        ]);

        $role = Role::create(['name' => UserRoles::MANAGER]);
        $user->assignRole([$role->id]);
    }
}
