<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class LoginController extends Controller
{
    /**
     * Show the login form.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle login request.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        // Check if user exists and is active
        $user = User::where('email', $credentials['email'])->first();

        if (!$user) {
            return back()->withErrors([
                'email' => 'Email tidak ditemukan.',
            ])->withInput();
        }

        if (!$user->is_active) {
            return back()->withErrors([
                'email' => 'Akun Anda tidak aktif. Silakan hubungi administrator.',
            ])->withInput();
        }

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            // Redirect based on role
            $user = Auth::user();
            switch ($user->role->name) {
                case 'admin':
                    return redirect()->intended('/admin/dashboard');
                case 'pelatih':
                    return redirect()->intended('/pelatih/dashboard');
                case 'anggota':
                    return redirect()->intended('/anggota/dashboard');
                default:
                    return redirect()->intended('/dashboard');
            }
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->withInput();
    }

    /**
     * Handle logout request.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Anda telah berhasil logout.');
    }
}
