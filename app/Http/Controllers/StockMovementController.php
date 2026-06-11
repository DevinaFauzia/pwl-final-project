<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\Branch;
use App\Models\ProductStock;
use App\Models\StockMovement;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class StockMovementController extends Controller
{
    public function index()
    {
        $branchId = Auth::user()->branch_id;
        if (!$branchId) {
            return redirect()->route('warehouse.dashboard')->with('error', 'Akun gudang belum dikaitkan dengan cabang. Hubungi admin.');
        }

        $movements = StockMovement::with(['product.category', 'user'])
            ->where('branch_id', $branchId)
            ->latest()
            ->get();
        return view('warehouse.stock.index', compact('movements'));
    }

    public function create()
    {
        $branchId = Auth::user()->branch_id;
        if (!$branchId) {
            return redirect()->route('warehouse.dashboard')->with('error', 'Akun gudang belum dikaitkan dengan cabang. Hubungi admin.');
        }

        $products = Product::with('category')->get();
        return view('warehouse.stock.create', compact('products'));
    }

    public function inventory()
    {
        $branchId = Auth::user()->branch_id;
        if (!$branchId) {
            return redirect()->route('warehouse.dashboard')->with('error', 'Akun gudang belum dikaitkan dengan cabang. Hubungi admin.');
        }

        $stocks = ProductStock::with('product')
            ->where('branch_id', $branchId)
            ->orderByDesc('stock')
            ->get();

        $criticalStockCount = $stocks->where('stock', '<', 10)->count();

        return view('warehouse.inventory.index', compact('stocks', 'criticalStockCount'));
    }

    public function opnameCreate()
    {
        $branchId = Auth::user()->branch_id;
        if (!$branchId) {
            return redirect()->route('warehouse.dashboard')->with('error', 'Akun gudang belum dikaitkan dengan cabang. Hubungi admin.');
        }

        $products = Product::with('category')->get();
        return view('warehouse.stock.opname', compact('products'));
    }

    public function opnameStore(Request $request)
    {
        $branchId = Auth::user()->branch_id;
        if (!$branchId) {
            return redirect()->route('warehouse.dashboard')->with('error', 'Akun gudang belum dikaitkan dengan cabang. Hubungi admin.');
        }

        $request->validate([
            'product_id' => 'required|exists:products,id',
            'actual_stock' => 'required|integer|min:0',
            'date' => 'required|date',
            'notes' => 'nullable|string'
        ]);

        $stock = ProductStock::firstOrCreate(
            ['branch_id' => $branchId, 'product_id' => $request->product_id],
            ['stock' => 0]
        );

        $currentStock = $stock->stock;
        $difference = $request->actual_stock - $currentStock;

        if ($difference === 0) {
            return redirect()->route('warehouse.inventory.index')->with('success', 'Stock opname berhasil dicatat. Stok tetap sama.');
        }

        $type = $difference > 0 ? 'in' : 'out';
        $quantity = abs($difference);

        if ($type === 'out' && $currentStock < $quantity) {
            return back()->withErrors(['actual_stock' => 'Penyesuaian opname tidak dapat mengurangi stok melebihi jumlah yang tersedia.'])->withInput();
        }

        DB::transaction(function () use ($request, $branchId, $stock, $type, $quantity, $currentStock) {
            if ($type === 'in') {
                $stock->increment('stock', $quantity);
            } else {
                $stock->decrement('stock', $quantity);
            }

            StockMovement::create([
                'branch_id' => $branchId,
                'product_id' => $request->product_id,
                'user_id' => Auth::id(),
                'type' => $type,
                'quantity' => $quantity,
                'date' => $request->date,
                'notes' => 'Stock opname: ' . ($request->notes ?? 'Penyesuaian stok aktual.') . ' (sebelumnya ' . $currentStock . ', sekarang ' . $request->actual_stock . ')',
            ]);
        });

        return redirect()->route('warehouse.inventory.index')->with('success', 'Stock opname berhasil disimpan.');
    }

    public function transferCreate()
    {
        $branchId = Auth::user()->branch_id;
        if (!$branchId) {
            return redirect()->route('warehouse.dashboard')->with('error', 'Akun gudang belum dikaitkan dengan cabang. Hubungi admin.');
        }

        $products = Product::with('category')->get();
        $branches = Branch::where('id', '!=', $branchId)->get();

        return view('warehouse.stock.transfer', compact('products', 'branches'));
    }

    public function transferStore(Request $request)
    {
        $branchId = Auth::user()->branch_id;
        if (!$branchId) {
            return redirect()->route('warehouse.dashboard')->with('error', 'Akun gudang belum dikaitkan dengan cabang. Hubungi admin.');
        }

        $request->validate([
            'product_id' => 'required|exists:products,id',
            'destination_branch_id' => 'required|exists:branches,id|not_in:' . $branchId,
            'quantity' => 'required|integer|min:1',
            'date' => 'required|date',
            'notes' => 'nullable|string'
        ]);

        $sourceStock = ProductStock::firstOrCreate(
            ['branch_id' => $branchId, 'product_id' => $request->product_id],
            ['stock' => 0]
        );

        if ($sourceStock->stock < $request->quantity) {
            return back()->withErrors(['quantity' => 'Stok tidak mencukupi untuk transfer.'])->withInput();
        }

        $destinationStock = ProductStock::firstOrCreate(
            ['branch_id' => $request->destination_branch_id, 'product_id' => $request->product_id],
            ['stock' => 0]
        );

        DB::transaction(function () use ($request, $branchId, $sourceStock, $destinationStock) {
            $sourceStock->decrement('stock', $request->quantity);
            $destinationStock->increment('stock', $request->quantity);

            StockMovement::create([
                'branch_id' => $branchId,
                'product_id' => $request->product_id,
                'user_id' => Auth::id(),
                'type' => 'out',
                'quantity' => $request->quantity,
                'date' => $request->date,
                'notes' => 'Transfer ke cabang #' . $request->destination_branch_id . ': ' . ($request->notes ?? 'Transfer stok antar cabang.'),
            ]);

            StockMovement::create([
                'branch_id' => $request->destination_branch_id,
                'product_id' => $request->product_id,
                'user_id' => Auth::id(),
                'type' => 'in',
                'quantity' => $request->quantity,
                'date' => $request->date,
                'notes' => 'Transfer dari cabang #' . $branchId . ': ' . ($request->notes ?? 'Penerimaan stok antar cabang.'),
            ]);
        });

        return redirect()->route('warehouse.inventory.index')->with('success', 'Transfer stok berhasil dicatat.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'type' => 'required|in:in,out',
            'quantity' => 'required|integer|min:1',
            'date' => 'required|date',
            'notes' => 'nullable|string'
        ]);

        $branchId = Auth::user()->branch_id;
        if (!$branchId) {
            return redirect()->route('warehouse.dashboard')->with('error', 'Akun gudang belum dikaitkan dengan cabang. Hubungi admin.');
        }

        $stock = ProductStock::firstOrCreate(
            ['branch_id' => $branchId, 'product_id' => $request->product_id],
            ['stock' => 0]
        );

        if ($request->type === 'out' && $stock->stock < $request->quantity) {
            return back()->withErrors(['quantity' => 'Stok tidak mencukupi untuk dikeluarkan.'])->withInput();
        }

        DB::transaction(function () use ($request, $branchId, $stock) {
            StockMovement::create([
                'branch_id' => $branchId,
                'product_id' => $request->product_id,
                'user_id' => Auth::id(),
                'type' => $request->type,
                'quantity' => $request->quantity,
                'date' => $request->date,
                'notes' => $request->notes,
            ]);

            if ($request->type === 'in') {
                $stock->increment('stock', $request->quantity);
            } else {
                $stock->decrement('stock', $request->quantity);
            }
        });

        return redirect()->route('warehouse.stock.index')->with('success', 'Pergerakan stok berhasil dicatat.');
    }
}
