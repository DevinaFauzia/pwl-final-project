<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $role = auth()->user()->role;
        
        if ($role == 'manager') {
            // Manager hanya lihat produk miliknya yang pending approval
            $products = Product::with('category', 'approvedBy')
                ->where('status', '!=', 'rejected')
                ->get();
            return view('manager.products.index', compact('products'));
        } else {
            // Owner lihat semua produk approved
            $products = Product::with('category')
                ->where('status', 'approved')
                ->get();
            return view('owner.products.index', compact('products'));
        }
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        $role = auth()->user()->role;
        
        if ($role == 'manager') {
            return view('manager.products.create', compact('categories'));
        } else {
            return view('owner.products.create', compact('categories'));
        }
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'sku' => 'required|unique:products',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
        ]);

        $role = auth()->user()->role;

        // Manager: produk dengan status pending
        if ($role == 'manager') {
            $validated['status'] = 'pending';
            Product::create($validated);
            return redirect()->route('manager.products.index')->with('success', 'Produk berhasil ditambahkan. Menunggu persetujuan owner.');
        } else {
            // Owner: produk langsung approved
            $validated['status'] = 'approved';
            $validated['approved_by'] = auth()->id();
            $validated['approved_at'] = now();
            Product::create($validated);
            return redirect()->route('owner.products.index')->with('success', 'Produk berhasil ditambahkan.');
        }
    }

    public function show(Product $product)
    {
        $role = auth()->user()->role;
        $redirectRoute = ($role == 'manager') ? 'manager.products.index' : 'owner.products.index';
        return redirect()->route($redirectRoute);
    }

    public function edit(Product $product)
    {
        $categories = Category::orderBy('name')->get();
        $role = auth()->user()->role;
        
        if ($role == 'manager') {
            return view('manager.products.edit', compact('product', 'categories'));
        } else {
            return view('owner.products.edit', compact('product', 'categories'));
        }
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'sku' => 'required|unique:products,sku,' . $product->id,
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
        ]);

        $product->update($validated);

        $role = auth()->user()->role;
        $redirectRoute = ($role == 'manager') ? 'manager.products.index' : 'owner.products.index';
        
        return redirect()->route($redirectRoute)->with('success', 'Produk berhasil diupdate.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        
        $role = auth()->user()->role;
        $redirectRoute = ($role == 'manager') ? 'manager.products.index' : 'owner.products.index';
        
        return redirect()->route($redirectRoute)->with('success', 'Produk berhasil dihapus.');
    }

    // Owner approval methods
    public function pending()
    {
        $products = Product::with('category')
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('owner.products.pending', compact('products'));
    }

    public function approve(Product $product)
    {
        $product->update([
            'status' => 'approved',
            'approved_by' => auth()->id(),
            'approved_at' => now(),
        ]);

        return redirect()->route('owner.products.pending')->with('success', 'Produk berhasil disetujui.');
    }

    public function reject(Request $request, Product $product)
    {
        $product->update([
            'status' => 'rejected',
        ]);

        return redirect()->route('owner.products.pending')->with('success', 'Produk ditolak.');
    }
}
