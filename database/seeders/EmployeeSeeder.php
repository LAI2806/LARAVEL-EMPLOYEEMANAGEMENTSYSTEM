<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\User;
use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get departments
        $hrDept = Department::where('name', 'Human Resources')->first();
        $itDept = Department::where('name', 'Information Technology')->first();
        $financeDept = Department::where('name', 'Finance')->first();
        $marketingDept = Department::where('name', 'Marketing')->first();

        // Create HR Manager
        if ($hrDept) {
            $hrUser = User::create([
                'name' => 'HR Manager',
                'email' => 'hr@company.com',
                'password' => bcrypt('password'),
                'role' => 'hr',
            ]);

            Employee::create([
                'user_id' => $hrUser->id,
                'department_id' => $hrDept->id,
                'first_name' => 'HR',
                'last_name' => 'Manager',
                'email' => 'hr@company.com',
                'phone' => '555-0101',
                'address' => '123 HR Street',
                'position' => 'HR Manager',
                'hire_date' => now()->subYears(2),
                'employment_status' => 'active',
            ]);
        }

        // Create IT Manager
        if ($itDept) {
            $itUser = User::create([
                'name' => 'IT Manager',
                'email' => 'manager@company.com',
                'password' => bcrypt('password'),
                'role' => 'manager',
            ]);

            Employee::create([
                'user_id' => $itUser->id,
                'department_id' => $itDept->id,
                'first_name' => 'IT',
                'last_name' => 'Manager',
                'email' => 'manager@company.com',
                'phone' => '555-0102',
                'address' => '456 IT Avenue',
                'position' => 'IT Manager',
                'hire_date' => now()->subYears(3),
                'employment_status' => 'active',
            ]);
        }

        // Create regular employees
        if ($financeDept) {
            $employee1 = User::create([
                'name' => 'John Doe',
                'email' => 'john@company.com',
                'password' => bcrypt('password'),
                'role' => 'employee',
            ]);

            Employee::create([
                'user_id' => $employee1->id,
                'department_id' => $financeDept->id,
                'first_name' => 'John',
                'last_name' => 'Doe',
                'email' => 'john@company.com',
                'phone' => '555-0103',
                'address' => '789 Finance Blvd',
                'position' => 'Accountant',
                'hire_date' => now()->subMonths(6),
                'employment_status' => 'active',
            ]);
        }

        if ($marketingDept) {
            $employee2 = User::create([
                'name' => 'Jane Smith',
                'email' => 'jane@company.com',
                'password' => bcrypt('password'),
                'role' => 'employee',
            ]);

            Employee::create([
                'user_id' => $employee2->id,
                'department_id' => $marketingDept->id,
                'first_name' => 'Jane',
                'last_name' => 'Smith',
                'email' => 'jane@company.com',
                'phone' => '555-0104',
                'address' => '321 Marketing St',
                'position' => 'Marketing Specialist',
                'hire_date' => now()->subMonths(4),
                'employment_status' => 'active',
            ]);
        }
    }
}
