<?php

namespace Database\Seeders;

use App\Models\Enums\UserRoles;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $role =  [
            [
                'name' => UserRoles::USER,
                'guard_name' => 'web',
            ],
            [
                'name' => UserRoles::TECHNICIAN,
                'guard_name' => 'web',
            ],
            [
                'name' => UserRoles::LOOKUP,
                'guard_name' => 'web',
            ],
        ];

        Role::insert($role);
    }
}
