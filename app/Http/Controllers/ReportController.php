<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Transaction;
use App\Models\ProductStock;
use App\Models\Branch;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    // TRANSACTIONS REPORT
    public function transactions(Request $request)
    {
        $user = Auth::user();

        if ($user->role === 'manager' && !$user->branch_id) {
            return redirect()->route('manager.dashboard')->with('error', 'Akun manager belum dikaitkan dengan cabang. Hubungi admin.');
        }

        $query = Transaction::with(['branch', 'user', 'details.product']);

        if ($user->role === 'manager') {
            $query->where('branch_id', $user->branch_id);
        } elseif ($user->role === 'owner' && $request->filled('branch_id')) {
            $query->where('branch_id', $request->branch_id);
        }

        if ($request->filled('start_date')) {
            $query->whereDate('transaction_date', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('transaction_date', '<=', $request->end_date);
        }

        $transactions = $query->orderByDesc('transaction_date')->get();
        $branches = Branch::all();
        $totalTransactions = $transactions->count();
        $totalAmount = $transactions->sum('total_amount');

        $viewPath = $user->role === 'owner' ? 'owner.reports.transactions' : 'manager.reports.transactions';
        
        return view($viewPath, compact('transactions', 'branches', 'totalTransactions', 'totalAmount'));
    }

    // STOCKS REPORT
    public function stocks(Request $request)
    {
        $user = Auth::user();

        if ($user->role === 'manager' && !$user->branch_id) {
            return redirect()->route('manager.dashboard')->with('error', 'Akun manager belum dikaitkan dengan cabang. Hubungi admin.');
        }

        $query = ProductStock::with(['product', 'branch']);

        if ($user->role === 'manager') {
            $query->where('branch_id', $user->branch_id);
        } elseif ($user->role === 'owner' && $request->filled('branch_id')) {
            $query->where('branch_id', $request->branch_id);
        }

        $stocks = $query->orderBy('branch_id')->orderBy('product_id')->get();
        $branches = Branch::all();
        $totalStocks = $stocks->count();
        $criticalStockCount = $stocks->where('stock', '<', 10)->count();

        $viewPath = $user->role === 'owner' ? 'owner.reports.stocks' : 'manager.reports.stocks';

        $branchName = $user->branch?->name;
        return view($viewPath, compact('stocks', 'branches', 'totalStocks', 'criticalStockCount', 'branchName'));
    }
}
