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

        /// [Login multiple table] 4. buat handle login untuk guard `web` (table users) dan guard `staff` (table staff)
        /// nama guard berdasarkan array `guards` pada config/auth.php
        if (Auth::guard('web')->attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('/dashboard');
        } else if (Auth::guard('staff')->attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('/dashboard');
        } else {
            return back()->with('login-failed', 'Email atau password salah');
        }

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
