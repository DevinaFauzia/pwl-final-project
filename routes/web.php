<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Models\Branch;
use App\Http\Controllers\BranchController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {

    $role = auth()->user()->role;

    if ($role == 'owner') {
        return redirect('/owner/dashboard');
    }

    elseif ($role == 'manager') {
        return redirect('/manager/dashboard');
    }

    elseif ($role == 'supervisor') {
        return redirect('/supervisor/dashboard');
    }

    elseif ($role == 'cashier') {
        return redirect('/cashier/dashboard');
    }

    elseif ($role == 'warehouse') {
        return redirect('/warehouse/dashboard');
    }

})->middleware(['auth'])->name('dashboard');

Route::middleware(['auth', 'role:owner'])
    ->prefix('owner')
    ->name('owner.')
    ->group(function () {

        Route::get('/dashboard', function () {

            $totalBranches = \App\Models\Branch::count();

            $totalUsers = \App\Models\User::count();

            return view('owner.dashboard', compact(
                'totalBranches',
                'totalUsers'
            ));

        })->name('dashboard');

        Route::resource('branches', BranchController::class);

    });

Route::middleware(['auth', 'role:manager'])->group(function () {

    Route::get('/manager/dashboard', function () {
        return view('manager.dashboard');
    });

});

Route::middleware(['auth', 'role:supervisor'])->group(function () {

    Route::get('/supervisor/dashboard', function () {
        return view('supervisor.dashboard');
    });

});

Route::middleware(['auth', 'role:cashier'])->group(function () {

    Route::get('/cashier/dashboard', function () {
        return view('cashier.dashboard');
    });

});

Route::middleware(['auth', 'role:warehouse'])->group(function () {

    Route::get('/warehouse/dashboard', function () {
        return view('warehouse.dashboard');
    });

});

Route::middleware('auth')->group(function () {

    Route::get('/profile', function () {
        return view('profile.edit');
    })->name('profile.edit');

});

require __DIR__.'/auth.php';