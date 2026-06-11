<?php

use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Models\Branch;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Product;
use App\Models\ProductStock;
use App\Models\StockMovement;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Owner\UserController as OwnerUserController;
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

            $totalTransactions = Transaction::whereDate('transaction_date', today())->count();
            $dailyOmset = Transaction::whereDate('transaction_date', today())->sum('total_amount');
            $criticalStocksCount = ProductStock::where('stock', '<', 10)->count();
            $branchesCount = Branch::count();
            $productCount = Product::count();
            $userCount = User::count();
            $recentTransactions = Transaction::with(['branch', 'user', 'details'])->latest()->take(5)->get();
            $criticalStockItems = ProductStock::with(['product', 'branch'])->where('stock', '<', 10)->get();

            return view('owner.dashboard', compact(
                'branchesCount',
                'productCount',
                'userCount',
                'totalTransactions',
                'dailyOmset',
                'criticalStocksCount',
                'recentTransactions',
                'criticalStockItems'
            ));

        })->name('dashboard');

        Route::resource('branches', BranchController::class);
        Route::resource('categories', CategoryController::class);
        Route::get('/products/pending', [ProductController::class, 'pending'])->name('products.pending');
        Route::post('/products/{product}/approve', [ProductController::class, 'approve'])->name('products.approve');
        Route::post('/products/{product}/reject', [ProductController::class, 'reject'])->name('products.reject');
        Route::resource('products', ProductController::class);
        Route::resource('users', OwnerUserController::class);
        Route::get('/reports/transactions', [ReportController::class, 'transactions'])->name('reports.transactions');
        Route::get('/reports/stocks', [ReportController::class, 'stocks'])->name('reports.stocks');

    });

Route::middleware(['auth', 'role:manager'])->group(function () {

    Route::get('/manager/dashboard', function () {
        $manager = auth()->user();
        $branchId = $manager->branch_id;
        $branchName = $manager->branch->name ?? null;

        if (!$branchId) {
            return view('manager.dashboard', [
                'totalTransactions' => 0,
                'dailyOmset' => 0,
                'criticalStocksCount' => 0,
                'recentTransactions' => collect(),
                'criticalStockItems' => collect(),
                'branchName' => null,
            ])->with('error', 'Akun manager belum dikaitkan dengan cabang. Hubungi admin.');
        }

        $today = today();
        $transactionsQuery = Transaction::where('branch_id', $branchId)
            ->whereDate('transaction_date', $today);

        $totalTransactions = $transactionsQuery->count();
        $dailyOmset = $transactionsQuery->sum('total_amount');

        $criticalStockItems = ProductStock::with('product')
            ->where('branch_id', $branchId)
            ->where('stock', '<', 10)
            ->orderBy('stock')
            ->get();

        $criticalStocksCount = $criticalStockItems->count();

        $recentTransactions = Transaction::with(['details', 'user'])
            ->where('branch_id', $branchId)
            ->whereDate('transaction_date', $today)
            ->latest()
            ->take(5)
            ->get();

        return view('manager.dashboard', compact(
            'totalTransactions',
            'dailyOmset',
            'criticalStocksCount',
            'recentTransactions',
            'criticalStockItems',
            'branchName'
        ));
    })->name('manager.dashboard');
    
    Route::resource('manager/products', ProductController::class)->names('manager.products');
    Route::get('/manager/reports/transactions', [ReportController::class, 'transactions'])->name('manager.reports.transactions');
    Route::get('/manager/reports/stocks', [ReportController::class, 'stocks'])->name('manager.reports.stocks');

});

Route::middleware(['auth', 'role:supervisor'])->group(function () {

    Route::get('/supervisor/dashboard', function () {
        $supervisor = auth()->user();
        $branchId = $supervisor->branch_id;

        if (!$branchId) {
            return view('supervisor.dashboard', [
                'totalTransactions' => 0,
                'dailyOmset' => 0,
                'totalItems' => 0,
                'cashiersActive' => collect(),
                'topProducts' => collect(),
                'recentTransactions' => collect(),
            ])->with('error', 'Akun supervisor belum dikaitkan dengan cabang. Hubungi admin.');
        }

        $today = today();
        
        $totalTransactions = Transaction::where('branch_id', $branchId)
            ->whereDate('transaction_date', $today)
            ->count();

        $dailyOmset = Transaction::where('branch_id', $branchId)
            ->whereDate('transaction_date', $today)
            ->sum('total_amount');

        $totalItems = \App\Models\TransactionDetail::whereIn('transaction_id', 
            Transaction::where('branch_id', $branchId)
                ->whereDate('transaction_date', $today)
                ->pluck('id')
        )->sum('quantity');

        $cashiersActive = Transaction::where('branch_id', $branchId)
            ->whereDate('transaction_date', $today)
            ->with('user')
            ->distinct('user_id')
            ->get()
            ->groupBy('user_id')
            ->map(function ($transactions) {
                return [
                    'cashier' => $transactions->first()->user,
                    'count' => $transactions->count(),
                    'total' => $transactions->sum('total_amount')
                ];
            });

        $topProducts = \App\Models\TransactionDetail::whereIn('transaction_id',
            Transaction::where('branch_id', $branchId)
                ->whereDate('transaction_date', $today)
                ->pluck('id')
        )->with('product')
            ->selectRaw('product_id, SUM(quantity) as total_qty, SUM(subtotal) as total_sales')
            ->groupBy('product_id')
            ->orderByRaw('total_qty DESC')
            ->take(5)
            ->get();

        $recentTransactions = Transaction::with(['details.product', 'user'])
            ->where('branch_id', $branchId)
            ->whereDate('transaction_date', $today)
            ->latest()
            ->take(10)
            ->get();

        return view('supervisor.dashboard', compact(
            'totalTransactions',
            'dailyOmset',
            'totalItems',
            'cashiersActive',
            'topProducts',
            'recentTransactions'
        ));
    })->name('supervisor.dashboard');

    Route::get('/supervisor/transactions', [TransactionController::class, 'index'])->name('supervisor.transactions.index');

});

Route::middleware(['auth', 'role:cashier'])->group(function () {

    Route::get('/cashier/dashboard', function () {
        $cashier = auth()->user();
        $branchId = $cashier->branch_id;

        if (!$branchId) {
            return view('cashier.dashboard', [
                'totalTransactions' => 0,
                'dailyOmset' => 0,
                'itemsSold' => 0,
                'lowStockCount' => 0,
                'recentTransactions' => collect(),
            ])->with('error', 'Akun kasir belum dikaitkan dengan cabang. Hubungi admin.');
        }

        $today = today();
        $transactionsQuery = Transaction::where('branch_id', $branchId)
            ->whereDate('transaction_date', $today);

        $totalTransactions = $transactionsQuery->count();
        $dailyOmset = $transactionsQuery->sum('total_amount');

        $itemsSold = TransactionDetail::whereIn('transaction_id', $transactionsQuery->pluck('id'))
            ->sum('quantity');

        $lowStockCount = ProductStock::where('branch_id', $branchId)
            ->where('stock', '<', 10)
            ->count();

        $recentTransactions = Transaction::with('user')
            ->where('branch_id', $branchId)
            ->whereDate('transaction_date', $today)
            ->latest()
            ->take(5)
            ->get();

        return view('cashier.dashboard', compact(
            'totalTransactions',
            'dailyOmset',
            'itemsSold',
            'lowStockCount',
            'recentTransactions'
        ));
    })->name('cashier.dashboard');

    Route::get('/cashier/pos', [TransactionController::class, 'create'])->name('cashier.pos.create');
    Route::post('/cashier/pos', [TransactionController::class, 'store'])->name('cashier.pos.store');

});

Route::middleware(['auth', 'role:warehouse'])->group(function () {

    Route::get('/warehouse/dashboard', function () {
        $warehouse = auth()->user();
        $branchId = $warehouse->branch_id;
        $branchName = $warehouse->branch->name ?? null;

        if (!$branchId) {
            return view('warehouse.dashboard', [
                'branchName' => null,
                'totalStockItems' => 0,
                'criticalStockCount' => 0,
                'totalTodayMovements' => 0,
                'totalIn' => 0,
                'totalOut' => 0,
                'recentMovements' => collect(),
                'criticalProducts' => collect(),
            ])->with('error', 'Akun gudang belum dikaitkan dengan cabang. Hubungi admin.');
        }

        $today = today();

        $stocks = ProductStock::with('product')
            ->where('branch_id', $branchId)
            ->get();

        $totalStockItems = $stocks->sum('stock');
        $criticalProducts = $stocks->where('stock', '<', 10);
        $criticalStockCount = $criticalProducts->count();

        $todayMovementsQuery = StockMovement::with(['product', 'user'])
            ->where('branch_id', $branchId)
            ->whereDate('date', $today);

        $totalTodayMovements = $todayMovementsQuery->count();
        $totalIn = (clone $todayMovementsQuery)->where('type', 'in')->sum('quantity');
        $totalOut = (clone $todayMovementsQuery)->where('type', 'out')->sum('quantity');

        $recentMovements = $todayMovementsQuery
            ->latest('date')
            ->take(5)
            ->get();

        return view('warehouse.dashboard', compact(
            'branchName',
            'totalStockItems',
            'criticalStockCount',
            'totalTodayMovements',
            'totalIn',
            'totalOut',
            'recentMovements',
            'criticalProducts'
        ));
    })->name('warehouse.dashboard');

    Route::get('/warehouse/stock', [StockMovementController::class, 'index'])->name('warehouse.stock.index');
    Route::get('/warehouse/stock/create', [StockMovementController::class, 'create'])->name('warehouse.stock.create');
    Route::post('/warehouse/stock', [StockMovementController::class, 'store'])->name('warehouse.stock.store');

    Route::get('/warehouse/inventory', [StockMovementController::class, 'inventory'])->name('warehouse.inventory.index');
    Route::get('/warehouse/stock/opname/create', [StockMovementController::class, 'opnameCreate'])->name('warehouse.stock.opname.create');
    Route::post('/warehouse/stock/opname', [StockMovementController::class, 'opnameStore'])->name('warehouse.stock.opname.store');
    Route::get('/warehouse/stock/transfer/create', [StockMovementController::class, 'transferCreate'])->name('warehouse.stock.transfer.create');
    Route::post('/warehouse/stock/transfer', [StockMovementController::class, 'transferStore'])->name('warehouse.stock.transfer.store');

});

Route::middleware('auth')->group(function () {

    Route::get('/profile', function () {
        return view('profile.edit');
    })->name('profile.edit');

});

require __DIR__.'/auth.php';