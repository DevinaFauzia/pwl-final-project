<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;
use App\Models\ProductStock;
use App\Models\StockMovement;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class StockMovementController extends Controller
{
    public function index()
    {
        $branchId = Auth::user()->branch_id;
        $movements = StockMovement::with(['product', 'user'])
            ->where('branch_id', $branchId)
            ->latest()
            ->get();
        return view('warehouse.stock.index', compact('movements'));
    }

    public function create()
    {
        $products = Product::all();
        return view('warehouse.stock.create', compact('products'));
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

        DB::transaction(function () use ($request, $branchId) {
            StockMovement::create([
                'branch_id' => $branchId,
                'product_id' => $request->product_id,
                'user_id' => Auth::id(),
                'type' => $request->type,
                'quantity' => $request->quantity,
                'date' => $request->date,
                'notes' => $request->notes,
            ]);

            $stock = ProductStock::firstOrCreate(
                ['branch_id' => $branchId, 'product_id' => $request->product_id],
                ['stock' => 0]
            );

            if ($request->type === 'in') {
                $stock->increment('stock', $request->quantity);
            } else {
                if ($stock->stock < $request->quantity) {
                    throw new \Exception('Stok tidak mencukupi untuk dikeluarkan.');
                }
                $stock->decrement('stock', $request->quantity);
            }
        });

        return redirect()->route('warehouse.stock.index')->with('success', 'Pergerakan stok berhasil dicatat.');
    }
}
