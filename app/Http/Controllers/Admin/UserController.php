<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Department;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function create()
    {
        $departments = Department::all();
        return view('admin.users.create', compact('departments'));
    }

    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('email', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status')) {
            $query->where('role', $request->status);
        }

        $users = $query->get();

        return view('admin.users.index', compact('users'));
    }

    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $departments = Department::all();

        return view('admin.users.edit', compact('user', 'departments'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'  => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role'  => 'required|in:hr,manager',
        ]);

        $user->update([
            'name'  => $request->name,
            'email' => $request->email,
            'role'  => $request->role,
        ]);

        return redirect()->route('users.index')
            ->with('success', 'User updated!');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'User deleted!');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'role'     => 'required|in:hr,manager',
        ]);

        $nameParts = explode(' ', $request->name, 2);

        $firstName = $nameParts[0];
        $lastName  = $nameParts[1] ?? '';

        // HR Department Auto Assignment
        $departmentId = null;

        if ($request->role === 'hr') {

            $hrDepartment = Department::where('name', 'Human Resources')->first();

            $departmentId = $hrDepartment?->id;
        }

        // CREATE USER
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
        ]);

        // CREATE EMPLOYEE
        Employee::create([
            'user_id'           => $user->id,
            'first_name'        => $firstName,
            'last_name'         => $lastName,
            'email'             => $request->email,
            'position'          => ucfirst($request->role),
            'department_id'     => $departmentId,
            'hire_date'         => now(),
            'employment_status' => 'active',
        ]);

        return redirect()->back()
            ->with('success', 'User created successfully!');
    }
}