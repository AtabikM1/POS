<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

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

    public function register()
    {
        if(Auth::check()) {
            return redirect('/');
        }
        return view('auth.register');
    }

    public function postregister(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            try {
                $validator = Validator::make($request->all(), [
                    'nama' => 'required|string|min:3|max:100',
                    'username' => 'required|string|min:3|max:20|unique:m_user,username',
                    'email' => 'required|email',
                    'level_id' => 'required|exists:m_level,level_id',
                    'password' => 'required|min:6|confirmed',
                ]);

                if ($validator->fails()) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Validasi gagal',
                        'msgField' => $validator->errors()
                    ]);
                }

                $user = UserModel::create([
                    'nama' => $request->nama,
                    'username' => $request->username,
                    'level_id' => $request->level_id,
                    'password' => Hash::make($request->password),
                ]);

                Auth::login($user);
                
                return response()->json([
                    'status' => true,
                    'message' => 'Registrasi berhasil',
                    'redirect' => url('/')
                ]);

            } catch (\Exception $e) {
                Log::error('Register error: ' . $e->getMessage());
                
                return response()->json([
                    'status' => false,
                    'message' => 'Terjadi kesalahan pada server: ' . $e->getMessage(),
                    'msgField' => []
                ], 500);
            }
        }
        
        return redirect('register');
    }
}