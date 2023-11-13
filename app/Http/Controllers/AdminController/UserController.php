<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use App\Models\Cabang;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->get();
        return view('admin.user.index',[
            'users'=> $users,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $role = UserRole::all();
        $cabang = Cabang::all();
    

        return view('admin.user.create',[
            'role' => $role,
            'cabang'=> $cabang,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        User::create([
            'cabang_id'=> $request->cabang_id,
            'role_id'=> $request->role_id,
            'nama_user'=> $request->nama_user,
            'no_pegawai'=>$request->no_pegawai,
            'email'=> $request->email,
            'password' => Hash::make('12345678'),

            

        ]);
        $request->session()->flash('success', 'Akun User berhasil ditambahkan');

        return redirect(route('admin.user.index'));

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = User::find($id);
       $role = UserRole::all();
       $cabang = Cabang::all();

        return view('admin.user.edit',[
            'data'=> $data,
            'role'=> $role,
            'cabang'=> $cabang,
        ]);
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
        $data = User::find($id);
        $data->role_id = $request->role_id;
        $data->cabang_id = $request->cabang_id;
        $data->nama_user = $request->nama_user;
        $data->no_pegawai = $request->no_pegawai;
        $data->email = $request->email;
          
        $data->save();
    
        $request->session()->flash('success', "Akun User berhasil diupdate");
    
        return redirect(route('admin.user.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        $user = User::find($id);
        $user->delete();

        $request->session()->flash('error', "Akun User Berhasil dihapus.");

        return redirect()->route('admin.user.index');
    }


    public function resetPassword(User $user, Request $request)
{
    $user->update([
        'password' => Hash::make('12345678'), // Ganti 'password_awal' dengan password yang Anda inginkan
    ]);

    $request->session()->flash('success', 'Password berhasil direset');

    return redirect()->route('admin.user.index');
}

}
