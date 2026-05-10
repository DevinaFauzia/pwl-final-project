<?php

use Illuminate\Support\Facades\Route;

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

Route::middleware(['auth', 'role:owner'])->group(function () {

    Route::get('/owner/dashboard', function () {
        return 'Dashboard Owner';
    });

});

Route::middleware(['auth', 'role:manager'])->group(function () {

    Route::get('/manager/dashboard', function () {
        return 'Dashboard Manager';
    });

});

Route::middleware(['auth', 'role:supervisor'])->group(function () {

    Route::get('/supervisor/dashboard', function () {
        return 'Dashboard Supervisor';
    });

});

Route::middleware(['auth', 'role:cashier'])->group(function () {

    Route::get('/cashier/dashboard', function () {
        return 'Dashboard Cashier';
    });

});

Route::middleware(['auth', 'role:warehouse'])->group(function () {

    Route::get('/warehouse/dashboard', function () {
        return 'Dashboard Warehouse';
    });

});

require __DIR__.'/auth.php';