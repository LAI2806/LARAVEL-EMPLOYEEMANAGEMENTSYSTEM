<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Department::create([
            'name' => 'Human Resources',
            'description' => 'Handles employee relations and HR operations',
            'status' => 'active',
        ]);

        Department::create([
            'name' => 'Information Technology',
            'description' => 'Manages IT infrastructure and development',
            'status' => 'active',
        ]);

        Department::create([
            'name' => 'Finance',
            'description' => 'Handles financial operations and accounting',
            'status' => 'active',
        ]);

        Department::create([
            'name' => 'Marketing',
            'description' => 'Manages marketing campaigns and brand strategy',
            'status' => 'active',
        ]);
    }
}
