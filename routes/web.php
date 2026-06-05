<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Models\Branch;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StockMovementController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ReportController;

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

            $totalTransactions = \App\Models\Transaction::whereDate('transaction_date', today())->count();
            $dailyOmset = \App\Models\Transaction::whereDate('transaction_date', today())->sum('total_amount');
            $criticalStocksCount = \App\Models\ProductStock::where('stock', '<', 10)->count();
            $recentTransactions = \App\Models\Transaction::with(['branch', 'user', 'details'])->latest()->take(5)->get();
            $criticalStockItems = \App\Models\ProductStock::with(['product', 'branch'])->where('stock', '<', 10)->get();

            return view('owner.dashboard', compact(
                'totalTransactions',
                'dailyOmset',
                'criticalStocksCount',
                'recentTransactions',
                'criticalStockItems'
            ));

        })->name('dashboard');

        Route::resource('branches', BranchController::class);
        Route::resource('products', ProductController::class);
        Route::get('/reports/transactions', [ReportController::class, 'transactions'])->name('reports.transactions');
        Route::get('/reports/stocks', [ReportController::class, 'stocks'])->name('reports.stocks');

    });

Route::middleware(['auth', 'role:manager'])->group(function () {

    Route::get('/manager/dashboard', function () {
        return view('manager.dashboard');
    })->name('manager.dashboard');
    
    Route::get('/manager/reports/transactions', [ReportController::class, 'transactions'])->name('manager.reports.transactions');
    Route::get('/manager/reports/stocks', [ReportController::class, 'stocks'])->name('manager.reports.stocks');

});

Route::middleware(['auth', 'role:supervisor'])->group(function () {

    Route::get('/supervisor/dashboard', function () {
        return view('supervisor.dashboard');
    })->name('supervisor.dashboard');

    Route::get('/supervisor/transactions', [TransactionController::class, 'index'])->name('supervisor.transactions.index');

});

Route::middleware(['auth', 'role:cashier'])->group(function () {

    Route::get('/cashier/dashboard', function () {
        return view('cashier.dashboard');
    })->name('cashier.dashboard');

    Route::get('/cashier/pos', [TransactionController::class, 'create'])->name('cashier.pos.create');
    Route::post('/cashier/pos', [TransactionController::class, 'store'])->name('cashier.pos.store');

});

Route::middleware(['auth', 'role:warehouse'])->group(function () {

    Route::get('/warehouse/dashboard', function () {
        return view('warehouse.dashboard');
    })->name('warehouse.dashboard');

    Route::get('/warehouse/stock', [StockMovementController::class, 'index'])->name('warehouse.stock.index');
    Route::get('/warehouse/stock/create', [StockMovementController::class, 'create'])->name('warehouse.stock.create');
    Route::post('/warehouse/stock', [StockMovementController::class, 'store'])->name('warehouse.stock.store');

});

Route::middleware('auth')->group(function () {

    Route::get('/profile', function () {
        return view('profile.edit');
    })->name('profile.edit');

});

require __DIR__.'/auth.php';