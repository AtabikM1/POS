<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function login()
    {
        if(Auth::check()) {
            return redirect('/');
        }
        return view('auth.login');
    }

    public function postlogin(Request $request) {
        if ($request->ajax() || $request->wantsJson())
        {
            try {
                $credentials = $request->only('username', 'password');
                if (Auth::attempt($credentials)) {
                    return response()->json([
                        'status' => true,
                        'message' => 'Login berhasil',
                        'redirect' => url('/')
                    ]);
                }

                return response()->json([
                    'status' => false,
                    'message' => 'Login gagal. Username atau password salah.',
                    'msgField' => [
                        'username' => ['Kredensial tidak valid'],
                        'password' => ['Kredensial tidak valid']
                    ]
                ]);
            } catch (\Exception $e) {
                // Log the error for debugging
                Log::error('Login error: ' . $e->getMessage());
                
                return response()->json([
                    'status' => false,
                    'message' => 'Terjadi kesalahan pada server: ' . $e->getMessage(),
                    'msgField' => []
                ], 500);
            }
        }  
        return redirect('login'); 
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('login');
    }
}