<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    
    public function login(Request $request)
    {
        // Validate the form data
        $credentials = $request->only('email', 'password');
        
      
        // Attempt to log in the user
        if (Auth::attempt($credentials)) {
          
            $user = Auth::user();

            if ($user->is_active == 0) {
                // If the user is not active, log them out and redirect back with a message
                return redirect()->route('login')->with('error', 'Akun Anda tidak aktif. Silakan hubungi administrator.');
            }
    

            if ($user->isSuperAdmin()) {
                ActivityLog::create([
                    'user_id' => Auth::id(),
                    'nama_user' =>  Auth::user()->nama_user,
                    'activity' => 'Login',
                    'description' => 'User berhasil login',
                    'timestamp' => now(),
                    'cabang_id' =>  Auth::user()->cabang_id,
                    'role_id' =>  Auth::user()->role_id,
                ]);
                return redirect()->route('superadmin.dashboard'); // Adjust the route accordingly
            } elseif ($user->isAdmin()) {
                ActivityLog::create([
                    'user_id' => Auth::id(),
                    'nama_user' =>  Auth::user()->nama_user,
                    'activity' => 'Login',
                    'description' => 'User berhasil login',
                    'timestamp' => now(),
                    'cabang_id' =>  Auth::user()->cabang_id,
                    'role_id' =>  Auth::user()->role_id,
                ]);
                return redirect()->route('admin.dashboard'); // Adjust the route accordingly
            } elseif ($user->isApproval()) {
                ActivityLog::create([
                    'user_id' => Auth::id(),
                    'nama_user' =>  Auth::user()->nama_user,
                    'activity' => 'Login',
                    'description' => 'User berhasil login',
                    'timestamp' => now(),
                    'cabang_id' =>  Auth::user()->cabang_id,
                    'role_id' =>  Auth::user()->role_id,
                ]);
                return redirect()->route('approval.dashboard'); // Adjust the route accordingly
            } else {
                ActivityLog::create([
                    'user_id' => Auth::id(),
                    'nama_user' =>  Auth::user()->nama_user,
                    'activity' => 'Login',
                    'description' => 'User berhasil login',
                    'timestamp' => now(),
                    'cabang_id' =>  Auth::user()->cabang_id,
                    'role_id' =>  Auth::user()->role_id,
                ]);
                return redirect()->route('user.home'); // Adjust the route accordingly
            }

        }
        // Authentication failed, redirect back with errors
        return redirect()->route('login')->with('error', 'Email atau Password salah, silakan coba kembali!');
    }

    public function logout()
    {
        
        Auth::logout();

        
        return redirect()->route('login');
    }

    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
