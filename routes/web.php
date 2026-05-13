<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\LeaveRequestController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\CronController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/institution', function () {     
    return view('institution.index');
})->name('institution.index');

Route::get('/run-scheduler', function () {
    Artisan::call('schedule:run');
    return response('ok', 200);
});

Route::middleware(['auth'])->group(function () {
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/', [ReportController::class, 'index'])->name('index');
        Route::get('/export-csv', [ReportController::class, 'exportCsv'])->name('exportCsv');
    });
});
Route::get('/debug-middleware', function () {
    $router = app('router');
    $middleware = $router->getMiddleware();
    return [
        'role_alias' => $middleware['role'] ?? 'NOT REGISTERED',
        'all_middleware' => array_keys($middleware),
        'laravel_version' => app()->version(),
    ];
});
Route::prefix('users')->name('users.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('index');
    Route::get('/create', [UserController::class, 'create'])->name('create');
    Route::post('/', [UserController::class, 'store'])->name('store');
    Route::get('/{user}', [UserController::class, 'show'])->name('show');
    Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit');
    Route::put('/{user}', [UserController::class, 'update'])->name('update');
    Route::delete('/{user}', [UserController::class, 'destroy'])->name('destroy');
});

Route::middleware(['auth'])->group(function () {
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::prefix('employees')->name('employees.')->middleware('role:admin,hr')->group(function () {

        Route::get('/', [EmployeeController::class, 'index'])->name('index');
        Route::get('/create', [EmployeeController::class, 'create'])->name('create');
        Route::post('/', [EmployeeController::class, 'store'])->name('store');

        Route::get('/{employee}', [EmployeeController::class, 'show'])->name('show');
        Route::get('/{employee}/edit', [EmployeeController::class, 'edit'])->name('edit');
        Route::put('/{employee}', [EmployeeController::class, 'update'])->name('update');
        Route::delete('/{employee}', [EmployeeController::class, 'destroy'])->name('destroy');
    });


    Route::prefix('manager')->name('manager.')->middleware('role:manager')->group(function () {

        Route::get('/employees', [EmployeeController::class, 'managerIndex'])->name('employees.index');
        Route::get('/employees/{employee}', [EmployeeController::class, 'managerShow'])->name('employees.show');
        Route::get('/department', [DepartmentController::class, 'managerShow'])->name('department.show');
    });

    Route::prefix('employee')->name('employee.')->middleware('role:employee')->group(function () {

        Route::get('/profile', [EmployeeController::class, 'myProfile'])->name('profile');
    });

    Route::prefix('departments')->name('departments.')->middleware('role:admin,hr,manager')->group(function () {

        Route::get('/', [DepartmentController::class, 'index'])->name('index');
        Route::get('/create', [DepartmentController::class, 'create'])->name('create');
        Route::post('/', [DepartmentController::class, 'store'])->name('store');

        Route::get('/{department}', [DepartmentController::class, 'show'])->name('show');
        Route::get('/{department}/edit', [DepartmentController::class, 'edit'])->name('edit');
        Route::put('/{department}', [DepartmentController::class, 'update'])->name('update');
        Route::delete('/{department}', [DepartmentController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('profile')->name('profile.')->group(function () {

        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('update');
        Route::put('/password', [ProfileController::class, 'updatePassword'])->name('password.update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
    });

});


Route::middleware(['auth'])->group(function () {

    Route::get('/attendance', [AttendanceController::class, 'index'])
        ->name('attendance.index')
        ->middleware('role:employee');

    Route::post('/attendance/time-in', [AttendanceController::class, 'timeIn'])
        ->name('attendance.timeIn')
        ->middleware('role:employee');

    Route::post('/attendance/time-out', [AttendanceController::class, 'timeOut'])
        ->name('attendance.timeOut')
        ->middleware('role:employee');

    Route::get('/attendance/team', [AttendanceController::class, 'team'])
        ->name('attendance.team')
        ->middleware('role:manager');

    Route::get('/attendance/report', [AttendanceController::class, 'report'])
        ->name('attendance.report')
        ->middleware('role:hr,admin');

    Route::get('/attendance/{attendance}/edit', [AttendanceController::class, 'edit'])
    ->name('attendance.edit')
    ->middleware('role:hr,admin');

    Route::put('/attendance/{attendance}', [AttendanceController::class, 'update'])
        ->name('attendance.update')
        ->middleware('role:hr,admin');

    Route::delete('/attendance/{attendance}', [AttendanceController::class, 'destroy'])
        ->name('attendance.destroy')
        ->middleware('role:admin');
});

Route::middleware(['auth'])->group(function () {

    // ✅ Static routes FIRST
    Route::get('/leave', [LeaveRequestController::class, 'index'])
        ->name('leave.index');

    Route::get('/leave/create', [LeaveRequestController::class, 'create'])
        ->name('leave.create')
        ->middleware('role:employee');

    Route::post('/leave/store', [LeaveRequestController::class, 'store'])
        ->name('leave.store')
        ->middleware('role:employee');

    // ✅ Dynamic {id} routes AFTER
    Route::get('/leave/{id}', [LeaveRequestController::class, 'show'])
        ->name('leave.show');

    Route::get('/leave/{id}/edit', [LeaveRequestController::class, 'edit'])
        ->name('leave.edit')
        ->middleware('role:admin');

    Route::put('/leave/{id}', [LeaveRequestController::class, 'update'])
        ->name('leave.update')
        ->middleware('role:admin');

    Route::post('/leave/{id}/approve', [LeaveRequestController::class, 'approve'])
        ->name('leave.approve')
        ->middleware('role:manager,admin');

    Route::post('/leave/{id}/reject', [LeaveRequestController::class, 'reject'])
        ->name('leave.reject')
        ->middleware('role:manager,admin');

    Route::delete('/leave/{id}', [LeaveRequestController::class, 'destroy'])
    ->name('leave.destroy')
    ->middleware('role:admin');
});


Route::middleware(['auth'])->group(function () {
    Route::prefix('reports')->name('reports.')->group(function () {
        Route::get('/', [ReportController::class, 'index'])->name('index');
    });
});

Route::get('/deactivated', function () {
    return view('employees.deactivated');
})->name('deactivated')->middleware('auth');

require __DIR__.'/auth.php';