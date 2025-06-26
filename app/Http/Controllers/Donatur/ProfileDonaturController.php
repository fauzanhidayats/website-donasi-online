<?php

namespace App\Http\Controllers\Donatur;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileDonaturController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('donatur.profile.index', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'username' => 'required|string|max:100',
            'email'    => 'nullable|email|max:100|unique:users,email,' . $user->id,
            'no_telp'  => 'nullable|string|max:20',
            'password' => 'nullable|min:6',
            'photo'    => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Handle photo upload & delete old photo if exists
        if ($request->hasFile('photo')) {
            if ($user->photo && Storage::disk('public')->exists($user->photo)) {
                Storage::disk('public')->delete($user->photo);
            }
            $validated['photo'] = $request->file('photo')->store('foto-users', 'public');
        }

        // Hash password if provided
        if ($request->filled('password')) {
            $validated['password'] = Hash::make($request->password);
        } else {
            unset($validated['password']);
        }

        // Update user profile
        $user->update($validated);

        return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
    }
}
