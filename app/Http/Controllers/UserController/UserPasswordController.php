<?php

namespace App\Http\Controllers\UserController;

use App\Http\Controllers\Controller;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserPasswordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function showChangePasswordFormUser(){
        return view('user.changepassword');
    }


    public function userchangePassword(Request $request){
        $request->validate([
            'current_password' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (!Hash::check($value, auth()->user()->password)) {
                        return $fail(__('Current Password Salah.'));
                    }
                },
            ],         
            'new_password' => 'required|min:8|different:current_password|confirmed',
        ], [
            'current_password.required' => 'Masukan current password terlebih dahulu.', 
            'new_password.required' => 'Masukan password baru terlebih dahulu.', 
            'new_password.min' => 'Password minimal terdiri dari 8 karakter', 
            'new_password.different' => 'Password baru harus berbeda dengan current password.',
            'new_password.confirmed' => 'Konfirmasi password baru tidak sesuai.',
        ]);
    

        // dd($request);

        $user = Auth::user();

        if (Hash::check($request->current_password, $user->password)) {
            $user->update([
                'password' => Hash::make($request->new_password),
            ]);
            return redirect()->route('user.password')->with('success', 'Password berhasil diubah.');
        } else {
            return redirect()->route('user.password');
        }
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
