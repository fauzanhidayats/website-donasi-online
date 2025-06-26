<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->get(); // Tidak pakai relasi role
        return view('admin.user.index', compact('users'));
    }

    public function create()
    {
        $roles = ['admin', 'donatur', 'pimpinan']; // Enum dari kolom `role`
        return view('admin.user.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'photo'    => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'username' => 'required|string|max:50',
            'email'    => 'nullable|email|max:100|unique:users,email',
            'password' => 'required|min:6',
            'no_telp'  => 'nullable|string|max:20',
            'role'     => 'required|in:admin,donatur,pimpinan',
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('foto-users', 'public');
        }

        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan.');
    }

    public function show(string $id)
    {
        $user = User::findOrFail($id);
        return view('admin.user.detail', compact('user'));
    }

    public function edit(string $id)
    {
        $user  = User::findOrFail($id);
        $roles = ['admin', 'donatur', 'pimpinan'];
        return view('admin.user.edit', compact('user', 'roles'));
    }

    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'photo'    => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'username' => 'required|string|max:50',
            'email'    => 'nullable|email|max:100|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6',
            'no_telp'  => 'nullable|string|max:20',
            'role'     => 'required|in:admin,donatur,pimpinan',
        ]);

        if ($request->hasFile('photo')) {
            if ($user->photo && Storage::disk('public')->exists($user->photo)) {
                Storage::disk('public')->delete($user->photo);
            }
            $validated['photo'] = $request->file('photo')->store('foto-users', 'public');
        }

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('users.index')->with('success', 'User berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $user = User::findOrFail($id);

        if ($user->photo && Storage::disk('public')->exists($user->photo)) {
            Storage::disk('public')->delete($user->photo);
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'User berhasil dihapus.');
    }
}
