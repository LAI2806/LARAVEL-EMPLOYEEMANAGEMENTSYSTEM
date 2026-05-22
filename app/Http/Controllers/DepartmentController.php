<?php
namespace App\Http\Controllers;
use App\Models\Department;
use App\Models\Employee;
use App\Models\User;    
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DepartmentController extends Controller
{

    public function index(Request $request)
    {
        $currentUser = Auth::user();

        $query = Department::with('manager');

        if ($currentUser->role === 'manager') {
            $query->where('manager_id', $currentUser->id);
        }

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $departments = $query->get();

        return view('departments.index', compact('departments', 'currentUser'));
    }

    public function create()
    {
        $managers = User::where('role', 'manager')->get();

        return view('departments.create', compact('managers'));
    }

    public function store(Request $request)
    {
        $department = Department::create($request->all());

        if ($request->manager_id) {
            $employee = Employee::where('user_id', $request->manager_id)->first();

            if ($employee) {
                $employee->department_id = $department->id;
                $employee->save();
            }
        }

        return redirect()->route('departments.index')
            ->with('success', 'Department created successfully.');
    }

    public function edit(Department $department)
    {
        $managers = User::where('role', 'manager')->get();

        return view('departments.edit', compact('department', 'managers'));
    }

    public function update(Request $request, Department $department)
    {
        $department->update($request->all());

        if ($request->manager_id) {
            $employee = Employee::where('user_id', $request->manager_id)->first();

            if ($employee) {
                $employee->department_id = $department->id;
                $employee->save();
            }
        }

        return redirect()->route('departments.index')
            ->with('success', 'Department updated.');
    }

    public function destroy(Department $department)
    {
        $department->delete();

        return redirect()->route('departments.index')
            ->with('success', 'Department deleted.');
    }

    public function show(Department $department)
    {
        return view('departments.show', compact('department'));
    }

    public function managerShow()
    {
        $user = Auth::user();

        $department = Department::with('employees')
            ->where('manager_id', $user->id)
            ->first();

        if (!$department) {
            return redirect()->route('dashboard')
                ->with('error', 'No department assigned to you.');
        }

        return view('departments.show', compact('department'));
    }
}