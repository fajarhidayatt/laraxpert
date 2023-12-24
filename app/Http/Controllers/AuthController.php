<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function loginView()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        /// validasi input request
        $credentials = $request->validate([
            'email' => 'required|email:dns',
            'password' => 'required|min:6'
        ]);

        /// cek apakah login berhasil
        if (Auth::attempt($credentials)) {
            /// re-generate session
            $request->session()->regenerate();

            /// redirect ke dashboard
            return redirect()->intended('/dashboard');
        } else {
            /// handle gagal login jika email atau password salah
            return back()->with('login-failed', 'Email atau password salah');
        }

        /// handle gagal validasi
        return back()->withErrors($credentials);
    }

    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'fullname' => 'required|min:3|max:100',
            'username' => 'required|min:3|max:100|alpha_dash',
            'email' => 'required|email:dns',
            'address' => 'nullable',
            'role' => 'required',
            'password' => 'required|min:6',
            'password_confirmation' => 'required|same:password',
        ]);

        /// jika data sesuai validasi
        if ($validatedData) {
            Staff::create($validatedData);

            return redirect('/login')->with('register-success', 'Registrasi berhasil, silahkan login');
        }

        /// jika data tidak sesuai validasi
        return back()->withErrors($validatedData);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
