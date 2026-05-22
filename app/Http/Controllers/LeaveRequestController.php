<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LeaveRequest;
use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class LeaveRequestController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        if ($user->role === 'employee') {
            $query = LeaveRequest::with(['employee.user'])
                ->where('employee_id', $user->employeeDetails->id)
                ->latest();

        } elseif ($user->role === 'manager') {
            $departmentId = $user->employeeDetails->department_id;

            $query = LeaveRequest::with(['employee.user'])
                ->whereHas('employee', function ($q) use ($departmentId) {
                    $q->where('department_id', $departmentId);
                })
                ->latest();

        } else {
            $query = LeaveRequest::with(['employee.user'])->latest();
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('leave_type')) {
            $query->where('leave_type', $request->leave_type);
        }

        $leaves = $query->get();

        return view('leave.index', compact('leaves'));
    }

    public function create()
    {
        return view('leave.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'leave_type' => 'required|in:Vacation Leave,Sick Leave,Emergency Leave,Maternity Leave,Paternity Leave,Solo Parent Leave',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date'   => 'required|date|after_or_equal:start_date',
            'reason'     => 'nullable|string|max:500'
        ]);

        $overlapping = LeaveRequest::where('employee_id', Auth::user()->employeeDetails->id)
            ->whereIn('status', ['pending', 'approved'])
            ->where(function ($q) use ($request) {
                $q->whereBetween('start_date', [$request->start_date, $request->end_date])
                ->orWhereBetween('end_date', [$request->start_date, $request->end_date])
                ->orWhere(function ($q) use ($request) {
                    $q->where('start_date', '<=', $request->start_date)
                        ->where('end_date', '>=', $request->end_date);
                });
            })->exists();

        if ($overlapping) {
            return back()->with('error', 'You already have a pending or approved leave that overlaps with the selected dates.')->withInput();
        }

        $hasAttendance = Attendance::where('employee_id', Auth::user()->employeeDetails->id)
            ->whereIn('status', ['Present', 'Late', 'Absent'])
            ->whereBetween('attendance_date', [$request->start_date, $request->end_date])
            ->exists();

        if ($hasAttendance) {
            return back()->with('error', 'You already have an attendance record on one or more of the selected dates.')->withInput();
        }

        LeaveRequest::create([
            'employee_id' => Auth::user()->employeeDetails->id,
            'leave_type'  => $request->leave_type,
            'start_date'  => $request->start_date,
            'end_date'    => $request->end_date,
            'reason'      => $request->reason,
            'status'      => 'pending'
        ]);

        return redirect()->route('leave.index')
            ->with('success', 'Leave request submitted successfully.');
    }

    public function approve($id)
    {
        $leave = LeaveRequest::findOrFail($id);

        if ($leave->status !== 'pending') {
            return back()->with('error', 'This request has already been processed.');
        }

        $leave->update([
            'status'      => 'approved',
            'approved_by' => Auth::id(),
            'approved_at' => now()
        ]);

        $this->markLeaveInAttendance($leave);

        return back()->with('success', 'Leave request approved.');
    }

    public function reject($id)
    {
        $leave = LeaveRequest::findOrFail($id);

        if ($leave->status !== 'pending') {
            return back()->with('error', 'This request has already been processed.');
        }

        $leave->update([
            'status'      => 'rejected',
            'approved_by' => Auth::id(),
            'approved_at' => now()
        ]);

        return back()->with('success', 'Leave request rejected.');
    }

    public function show($id)
    {
        $leave = LeaveRequest::with(['employee.user', 'approver'])
            ->findOrFail($id);


        if (Auth::user()->role === 'employee') {
            if ($leave->employee_id !== Auth::user()->employeeDetails->id) {
                abort(403);
            }
        }

        return view('leave.show', compact('leave'));
    }

    public function edit($id)
    {
        $leave = LeaveRequest::findOrFail($id);
        return view('leave.edit', compact('leave'));
    }

    public function update(Request $request, $id)
    {
        $leave = LeaveRequest::findOrFail($id);

        $request->validate([
            'leave_type' => 'required|in:Vacation Leave,Sick Leave,Emergency Leave,Maternity Leave,Paternity Leave,Solo Parent Leave',
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after_or_equal:start_date',
            'status'     => 'required|in:pending,approved,rejected',
            'reason'     => 'nullable|string|max:500'
        ]);

        $leave->update([
            'leave_type' => $request->leave_type,
            'start_date' => $request->start_date,
            'end_date'   => $request->end_date,
            'reason'     => $request->reason,
            'status'     => $request->status
        ]);

        if ($request->status === 'approved') {
            $this->markLeaveInAttendance($leave);
        }

        return redirect()->route('leave.index')
            ->with('success', 'Leave request updated.');
    }

    public function destroy($id)
    {
        $leave = LeaveRequest::findOrFail($id);
        $leave->delete();

        return back()->with('success', 'Leave request deleted.');
    }

    private function markLeaveInAttendance($leave)
    {
        $dates = Carbon::parse($leave->start_date)
            ->toPeriod($leave->end_date);

        foreach ($dates as $date) {
            Attendance::updateOrCreate(
                [
                    'employee_id'     => $leave->employee_id,
                    'attendance_date' => $date->toDateString()
                ],
                [
                    'status'  => 'On Leave',
                    'remarks' => 'Approved leave'
                ]
            );
        }
    }
}