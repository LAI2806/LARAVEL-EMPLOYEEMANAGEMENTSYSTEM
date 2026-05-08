<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Employee;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::create([
            'name'     => 'Admin',
            'email'    => 'admin@admin.com',
            'password' => Hash::make('password123'),
            'role'     => 'admin',
        ]);

        Employee::create([
            'user_id'           => $user->id,
            'first_name'        => 'Admin',
            'last_name'         => '',
            'email'             => 'admin@admin.com',
            'position'          => 'Admin',
            'department_id'     => null,
            'hire_date'         => now(),
            'employment_status' => 'active',
        ]);
    }
}