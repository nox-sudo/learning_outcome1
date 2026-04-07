<?php

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    public function run()
    {
        $roles = ['admin', 'sales', 'warehouse', 'purchasing', 'route'];

        foreach ($roles as $role) {
            Role::create(['name' => $role]);
        }
    }
}
