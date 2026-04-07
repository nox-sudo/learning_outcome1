<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;

class UserSeeder extends Seeder
{
    public function run()
    {
        $users = [
            ['email' => 'admin@halcon.com',   'name' => 'Admin Halcón',  'role' => 'admin'],
            ['email' => 'ventas@halcon.com',  'name' => 'Carlos Ventas', 'role' => 'sales'],
            ['email' => 'almacen@halcon.com', 'name' => 'María Almacén', 'role' => 'warehouse'],
            ['email' => 'compras@halcon.com', 'name' => 'Luis Compras',  'role' => 'purchasing'],
            ['email' => 'ruta@halcon.com',    'name' => 'Pedro Ruta',    'role' => 'route'],
        ];

        foreach ($users as $userData) {
            $role = Role::where('name', $userData['role'])->first();
            User::create([
                'name'     => $userData['name'],
                'email'    => $userData['email'],
                'password' => Hash::make('password'),
                'role_id'  => $role->id,
                'active'   => 1,
            ]);
        }
    }
}
