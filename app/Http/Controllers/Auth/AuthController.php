<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Menampilkan halaman registrasi
     */
    public function showRegisterForm()
    {
        return view('auth.register'); // Ganti dengan view registrasi sesuai struktur proyek kamu
    }

    /**
     * Menampilkan halaman login
     */
    public function showLoginForm()
    {
        return view('auth.login'); // Ganti dengan view login sesuai struktur proyek kamu
    }

    /**
     * Menangani proses registrasi
     */
    public function register(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'username' => 'required|string|max:50|unique:users,username',
            'email' => 'nullable|email|max:100|unique:users,email',
            'password' => 'required|string|min:6',
            'no_telp' => 'nullable|string|max:20',
        ]);

        // Buat user baru
        User::create([
            'username' => $validated['username'],
            'email' => $validated['email'] ?? null,
            'password' => Hash::make($validated['password']),
            'no_telp' => $validated['no_telp'] ?? null,
            'role' => 'donatur', // default role
        ]);

        return redirect()->route('login')->with('success', 'Akun berhasil dibuat. Silakan login.');
    }

    /**
     * Menangani proses login
     */
    public function login(Request $request)
    {
        // Validasi input login
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Coba login
        if (!Auth::attempt($credentials)) {
            throw ValidationException::withMessages([
                'email' => ['Email atau password salah.'],
            ]);
        }

        // Regenerasi sesi
        $request->session()->regenerate();

        $user = Auth::user();

        // Redirect berdasarkan role
        return match ($user->role) {
            'admin' => redirect()->route('dashboard.admin'),
            'donatur' => redirect()->route('dashboard.donatur'),
            'pimpinan' => redirect()->route('dashboard.pimpinan'),
            default => redirect('/'),
        };
    }

    /**
     * Menangani logout
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'Berhasil logout.');
    }
}
