<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $branches = Branch::latest()->get();

        return view('branches.index', compact('branches'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('branches.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'city' => 'required',
            'address' => 'required',
        ]);

        \App\Models\Branch::create([
            'name' => $request->name,
            'city' => $request->city,
            'address' => $request->address,
        ]);

        return redirect()
            ->route('owner.branches.index')
            ->with('success', 'Cabang berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $branch = \App\Models\Branch::findOrFail($id);

        return view('branches.edit', compact('branch'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required',
            'city' => 'required',
            'address' => 'required',
        ]);

        $branch = \App\Models\Branch::findOrFail($id);

        $branch->update([
            'name' => $request->name,
            'city' => $request->city,
            'address' => $request->address,
        ]);

        return redirect()
            ->route('owner.branches.index')
            ->with('success', 'Cabang berhasil diupdate');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $branch = \App\Models\Branch::findOrFail($id);

        $branch->delete();

        return redirect()
            ->route('owner.branches.index')
            ->with('success', 'Cabang berhasil dihapus');
    }
}

