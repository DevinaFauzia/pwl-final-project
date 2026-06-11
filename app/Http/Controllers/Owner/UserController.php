<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::whereIn('role', ['manager', 'warehouse', 'cashier', 'supervisor'])
            ->with('branch')
            ->get();

        return view('owner.users.index', compact('users'));
    }

    public function create()
    {
        $branches = Branch::all();
        $roles = ['manager', 'warehouse', 'cashier', 'supervisor'];

        return view('owner.users.create', compact('branches', 'roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:manager,warehouse,cashier,supervisor',
            'branch_id' => 'required|exists:branches,id',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'branch_id' => $request->branch_id,
        ]);

        return redirect()->route('owner.users.index')
            ->with('success', 'Pengguna baru berhasil dibuat.');
    }

    public function edit(User $user)
    {
        if ($user->role === 'owner') {
            abort(403);
        }

        $branches = Branch::all();
        $roles = ['manager', 'warehouse', 'cashier', 'supervisor'];

        return view('owner.users.edit', compact('user', 'branches', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        if ($user->role === 'owner') {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:manager,warehouse,cashier,supervisor',
            'branch_id' => 'required|exists:branches,id',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->branch_id = $request->branch_id;
        $user->save();

        return redirect()->route('owner.users.index')
            ->with('success', 'Data pengguna berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if ($user->role === 'owner') {
            abort(403);
        }

        $user->delete();

        return redirect()->route('owner.users.index')
            ->with('success', 'Pengguna berhasil dihapus.');
    }
}
