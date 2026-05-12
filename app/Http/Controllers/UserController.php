<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }
        $users = $query->latest()->paginate(15);
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users',
            'role'     => 'required|in:admin,user',
            'password' => 'required|min:8|confirmed',
            'phone'    => 'nullable|string|max:20',
            'address'  => 'nullable|string',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'role'     => $request->role,
            'password' => Hash::make($request->password),
            'phone'    => $request->phone,
            'address'  => $request->address,
        ]);

        return redirect('/users')->with('success', '✅ User berhasil ditambahkan!');
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|unique:users,email,' . $user->id,
            'role'    => 'required|in:admin,user',
            'phone'   => 'nullable|string|max:20',
            'address' => 'nullable|string',
        ]);

        $user->update($request->only(['name', 'email', 'role', 'phone', 'address']));

        return redirect('/users')->with('success', '✅ User berhasil diupdate!');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', '❌ Tidak bisa menghapus akun sendiri!');
        }
        $user->delete();
        return redirect('/users')->with('success', '🗑️ User berhasil dihapus!');
    }

    public function resetPassword(User $user)
    {
        $user->update(['password' => Hash::make('password123')]);
        return redirect('/users')->with('success', '🔑 Password direset ke: password123');
    }
}