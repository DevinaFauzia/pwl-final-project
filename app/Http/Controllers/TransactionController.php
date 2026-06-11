<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductStock;
use App\Models\StockMovement;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    // Untuk Supervisor memantau transaksi harian
    public function index()
    {
        $branchId = Auth::user()->branch_id;
        if (!$branchId) {
            return redirect()->route('supervisor.dashboard')->with('error', 'Akun supervisor belum dikaitkan dengan cabang. Hubungi admin.');
        }

        $transactions = Transaction::with(['user', 'details.product'])
            ->where('branch_id', $branchId)
            ->whereDate('transaction_date', today())
            ->latest()
            ->get();
        return view('supervisor.transactions.index', compact('transactions'));
    }

    // Untuk Kasir POS
    public function create(Request $request)
    {
        $branchId = Auth::user()->branch_id;
        if (!$branchId) {
            return redirect()->route('cashier.dashboard')->with('error', 'Akun kasir belum dikaitkan dengan cabang. Hubungi admin.');
        }

        $stocksQuery = ProductStock::with('product.category')
            ->where('branch_id', $branchId)
            ->where('stock', '>', 0);

        if ($request->filled('q')) {
            $search = $request->q;
            $stocksQuery->whereHas('product', function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('sku', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category_id')) {
            $categoryId = $request->category_id;
            $stocksQuery->whereHas('product', function ($query) use ($categoryId) {
                $query->where('category_id', $categoryId);
            });
        }

        $stocks = $stocksQuery->get();
        $categories = Category::orderBy('name')->get();
        $cashierName = Auth::user()->name;

        return view('cashier.pos.index', compact('stocks', 'cashierName', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.price' => 'required|numeric|min:0',
            'payment_amount' => 'nullable|numeric|min:0',
        ]);

        $branchId = Auth::user()->branch_id;
        if (!$branchId) {
            return redirect()->route('cashier.dashboard')->with('error', 'Akun kasir belum dikaitkan dengan cabang. Hubungi admin.');
        }

        try {
            DB::transaction(function () use ($request, $branchId) {
                $totalAmount = collect($request->items)
                    ->reduce(fn ($carry, $item) => $carry + ($item['quantity'] * $item['price']), 0);

                if ($request->filled('payment_amount') && $request->payment_amount < $totalAmount) {
                    throw new \Exception('Jumlah bayar harus sama atau lebih besar dari total transaksi.');
                }

                $transaction = Transaction::create([
                    'branch_id' => $branchId,
                    'user_id' => Auth::id(),
                    'total_amount' => $totalAmount,
                    'transaction_date' => now(),
                ]);

                foreach ($request->items as $item) {
                    TransactionDetail::create([
                        'transaction_id' => $transaction->id,
                        'product_id' => $item['product_id'],
                        'quantity' => $item['quantity'],
                        'subtotal' => $item['quantity'] * $item['price'],
                    ]);

                    $stock = ProductStock::where('branch_id', $branchId)
                        ->where('product_id', $item['product_id'])
                        ->lockForUpdate()
                        ->first();

                    if (!$stock || $stock->stock < $item['quantity']) {
                        throw new \Exception("Stok tidak mencukupi untuk produk ID " . $item['product_id']);
                    }

                    $stock->decrement('stock', $item['quantity']);

                    StockMovement::create([
                        'branch_id' => $branchId,
                        'product_id' => $item['product_id'],
                        'user_id' => Auth::id(),
                        'type' => 'out',
                        'quantity' => $item['quantity'],
                        'notes' => 'Penjualan kasir',
                        'date' => now(),
                    ]);
                }
            });
        } catch (\Exception $e) {
            return back()->withErrors(['items' => $e->getMessage()])->withInput();
        }

        return redirect()->back()->with('success', 'Transaksi berhasil disimpan.');
    }
}
