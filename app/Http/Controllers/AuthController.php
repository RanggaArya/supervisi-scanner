<?php

// app/Http/Controllers/AuthController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    private $allowedTypes = ['it', 'alkes', 'rt'];
    
    public function showLoginForm($type)
    {
        // Validasi type
        if (!in_array($type, $this->allowedTypes)) {
            return redirect()->route('home')
                ->with('error', 'Jenis inventory tidak valid');
        }
        
        return view('auth.login', compact('type'));
    }
    
    public function login(Request $request, $type)
    {
        // Validasi type
        if (!in_array($type, $this->allowedTypes)) {
            return redirect()->route('home')
                ->with('error', 'Jenis inventory tidak valid');
        }
        
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
        
        // Tentukan koneksi database berdasarkan type
        $connection = 'mysql_' . strtolower($type);
        
        // Simpan type inventory dan connection di session
        Session::put('inventory_type', $type);
        Session::put('db_connection', $connection);
        
        try {
            // Proses authentication
            $user = DB::connection($connection)
                ->table('users')
                ->where('email', $credentials['email'])
                ->first();
                
            if ($user && password_verify($credentials['password'], $user->password)) {
                Session::put('user_id', $user->id);
                Session::put('user_name', $user->name);
                
                // UPDATE: Redirect ke Dashboard (Menu), bukan scanner
                return redirect()->route('dashboard')
                    ->with('success', 'Login berhasil! Silakan pilih menu.');
            }
            
            return back()
                ->withErrors(['email' => 'Email atau password salah'])
                ->withInput($request->only('email'));
                
        } catch (\Exception $e) {
            return back()
                ->withErrors(['email' => 'Terjadi kesalahan koneksi database'])
                ->withInput($request->only('email'));
        }
    }
    
    public function logout()
    {
        Session::flush();
        return redirect()->route('home')
            ->with('success', 'Logout berhasil');
    }
}

