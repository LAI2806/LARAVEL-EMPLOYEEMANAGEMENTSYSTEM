<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Employee;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class EmployeeController extends Controller
{
    public function index(Request $request) 
    {
        $query = Employee::with('user', 'department');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%$search%")
                ->orWhere('last_name', 'like', "%$search%")
                ->orWhere('email', 'like', "%$search%")
                ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%$search%"]); // ✅ ADD THIS
            });
        }

        if ($request->filled('department')) {
            $query->where('department_id', $request->department);
        }

        if ($request->filled('status')) {
            $query->where('employment_status', $request->status);
        }


        $employees = $query->paginate(15);
        $departments = Department::all();

        return view('employees.index', compact('employees', 'departments'));
    }

    public function create()
    {
        $departments = Department::all();
        return view('employees.create', compact('departments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users,email|unique:employees,email',
            'department_id' => 'required',
            'position' => 'required',
        ]);

        DB::beginTransaction();

        try {
            $user = User::create([
                'name' => $request->first_name . ' ' . $request->last_name,
                'email' => $request->email,
                'password' => Hash::make('password123'),
                'role' => 'employee',
            ]);

            Employee::create([
                'user_id' => $user->id,
                'department_id' => $request->department_id,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => collect([
                            $request->building,
                            $request->street,
                            $request->barangay,
                            $request->city,
                            $request->province,
                            $request->district,
                            $request->postal_code,
                        ])->filter()->implode(', '),
                'position' => $request->position,
                'hire_date' => $request->hire_date,
                'employment_status' => $request->employment_status ?? 'active',
            ]);

            DB::commit();

            return redirect()->route('employees.index')->with('success', 'Employee created successfully!');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', $e->getMessage());
        }
    }

    public function show(Employee $employee)
    {
        return view('employees.show', compact('employee'));
    }

    public function edit(Employee $employee)
    {
        $departments = Department::all();
        $addressParts = explode(', ', $employee->address ?? '', 7);
        return view('employees.edit', compact('employee', 'departments', 'addressParts'));
    }

    public function update(Request $request, Employee $employee)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => "required|email|unique:employees,email,{$employee->id}",
            'department_id' => 'required',
            'position' => 'required',
        ]);

        $employee->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => collect([
                        $request->building,
                        $request->street,
                        $request->barangay,
                        $request->city,
                        $request->province,
                        $request->district,
                        $request->postal_code,
                    ])->filter()->implode(', '),
            'department_id' => $request->department_id,
            'position' => $request->position,
            'hire_date' => $request->hire_date,
            'employment_status' => $request->employment_status,
        ]);

        if ($employee->user) {
            $employee->user->update(['email' => $request->email]);
        }

        return redirect()->route('employees.index')->with('success', 'Employee updated successfully!');
    }

    public function destroy(Employee $employee)
    {
        if ($employee->user) {
            $employee->user->delete();
        }
        $employee->delete();

        return redirect()->route('employees.index')->with('success', 'Employee deleted successfully!');
    }

    public function myProfile()
    {
        $employee = Auth::user()->employee;

        if (!$employee) {
            return redirect()->route('dashboard')->with('error', 'Employee profile not found.');
        }

        return view('employees.profile', compact('employee'));
    }

    public function managerIndex(Request $request)
    {
        $user = Auth::user();
        $department = Department::where('manager_id', $user->id)->first();

        if (!$department) {
            return redirect()->route('dashboard')->with('error', 'No department assigned.');
        }

        $query = Employee::with('department')
            ->where('department_id', $department->id)
            ->whereHas('user', function ($q) {
                $q->where('role', 'employee');
            });

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%$search%")
                ->orWhere('last_name', 'like', "%$search%")
                ->orWhere('email', 'like', "%$search%")
                ->orWhereRaw("CONCAT(first_name, ' ', last_name) LIKE ?", ["%$search%"]);
            });
        }

        if ($request->filled('status')) {
            $query->where('employment_status', $request->status);
        }

        $employees = $query->get();
        return view('employees.manager', compact('employees'));
    }

    public function managerShow(Employee $employee)
    {
        $user = Auth::user();

        if ($user->role === 'manager') {
            if ($employee->department_id !== $user->employee->department_id 
                || $employee->user->role !== 'employee') {
                abort(403); 
            }
        }

        return view('employees.show', compact('employee'));
    }
}