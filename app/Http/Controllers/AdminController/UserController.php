<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use App\Models\Cabang;
use App\Models\DetailMember;
use App\Models\File;
use App\Models\User;
use App\Models\UserRole;
use Auth;
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
        return view('superadmin.user.index',[
            'users'=> $users,
        ]);
    }

public function userindex()
{
    // Mendapatkan role pengguna yang sedang login
    $Cabang = Auth::user()->cabang_id;

    // Menyaring data berdasarkan role pengguna
    $users = User::where('cabang_id', $Cabang)
    ->whereDoesntHave('Role', function ($query) {
        $query->where('role_id', '4');
    })
    ->orderBy('created_at', 'desc')
    ->get();

    return view('admin.user.index', [
        'users' => $users,
    ]);
}


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $role = UserRole::all();
        $cabang = Cabang::all();
    

        return view('superadmin.user.create',[
            'role' => $role,
            'cabang'=> $cabang,
        ]);
    }
    
    public function usercreate()
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

        
        $loggedInUser = auth()->user();
        $loggedInUsername = $loggedInUser->nama_user; 
        $isApproval = $request->has('flexCheckIndeterminate');

      
        $existingUser = User::where('email', $request->email)->first();
        $existingno = User::where('no_pegawai', $request->no_pegawai)->first();


        if ($existingUser) {
            // Jika email sudah ada, tampilkan pesan flash error
            $request->session()->flash('error', 'Gagal menyimpan data, email sudah terdaftar.');
            return redirect(route('superadmin.user.index'));
        }

        if ($existingno) {
            // Jika email sudah ada, tampilkan pesan flash error
            $request->session()->flash('error', 'Gagal menyimpan data, no pegawai sudah terdaftar.');
            return redirect(route('superadmin.user.index'));
        }
    

        User::create([
            'cabang_id'=> $request->cabang_id,
            'role_id'=> $request->role_id,
            'nama_user'=> $request->nama_user,
            'no_pegawai'=>$request->no_pegawai,
            'email'=> $request->email,
            'password' => Hash::make('12345678'),
            'created_by' => $loggedInUsername,
            'is_approval' => $isApproval,
        ]);



        $request->session()->flash('success', 'Akun User berhasil ditambahkan.');

        return redirect(route('superadmin.user.index'));

    }

    public function userstore(Request $request)
    {
        // Mendapatkan pengguna yang saat ini login
        $loggedInUser = Auth::user();
       
        $loggedInUsername = $loggedInUser->nama_user; 
        $cabangId = $loggedInUser->cabang_id;
        $apporval = $request->has('flexCheckIndeterminate');
      
        $existingUser = User::where('email', $request->email)
         ->where('cabang_id', $cabangId)
        ->first();
      

        $existingno = User::where('no_pegawai', $request->no_pegawai)
        ->where('cabang_id', $cabangId)
        ->first();


        if ($existingUser) {
            // Jika email sudah ada, tampilkan pesan flash error
            $request->session()->flash('error', 'Gagal menyimpan data, email sudah terdaftar.');
            return redirect(route('admin.user.index'));
        }

        if ($existingno) {
            // Jika email sudah ada, tampilkan pesan flash error
            $request->session()->flash('error', 'Gagal menyimpan data, no pegawai sudah terdaftar.');
            return redirect(route('admin.user.index'));
        }
    
        User::create([
            'cabang_id' => $loggedInUser->cabang_id,
            'role_id' => $request->role_id,
            'nama_user' => $request->nama_user,
            'no_pegawai' => $request->no_pegawai,
            'email' => $request->email,
            'password' => Hash::make('12345678'),
            'created_by' => $loggedInUsername,
            'is_approval' => $apporval,
        ]);
    
        $request->session()->flash('success', 'Akun User berhasil ditambahkan.');
    
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

        return view('superadmin.user.edit',[
            'data'=> $data,
            'role'=> $role,
            'cabang'=> $cabang,
        ]);
    }

    public function usershow(string $id)
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
        
        $loggedInUser = auth()->user();
        $loggedInUsername = $loggedInUser->nama_user; 
        $data = User::find($id);
        

        if($data->role_id == 1){
        $adminCount = User::whereHas('Role', function ($query) {
            $query->where('nama_role', 'Super Admin');
        })->count();


        if ($adminCount <= 1) {
            return redirect()->route('superadmin.user.index')->with('error', 'Tidak dapat melakukan update pada akun superadmin terakhir.');
        }
    }
        $existingUser = User::where('email', $request->email)
        ->where('id', '!=', $id)->first();

        $existingno = User::where('no_pegawai', $request->no_pegawai)  ->where('id', '!=', $id)->first();


       
 if ($existingUser) {
    // Jika email sudah ada, tampilkan pesan flash error
    $request->session()->flash('error', 'Gagal menyimpan data, email sudah terdaftar.');
    return redirect(route('superadmin.user.index'));
}

if ($existingno) {
    // Jika email sudah ada, tampilkan pesan flash error
    $request->session()->flash('error', 'Gagal menyimpan data, no pegawai sudah terdaftar.');
    return redirect(route('superadmin.user.index'));
}

        $data->role_id = $request->role_id;
        $data->cabang_id = $request->cabang_id;
        $data->nama_user = $request->nama_user;
        $data->no_pegawai = $request->no_pegawai;
        $data->email = $request->email;
        $data->updated_by = $loggedInUsername;
        $isApproval = $request->has('flexCheckIndeterminate');


        $data->is_approval = $isApproval;

       
          
        $data->save();
    
        $request->session()->flash('success', "Akun User berhasil diupdate.");
    
        return redirect(route('superadmin.user.index'));
    }

public function userupdate(Request $request, string $id)
    {
        $loggedInUser = Auth::user();
        $loggedInUsername = $loggedInUser->nama_user; 

        $data = User::find($id);
        $cabangId = $loggedInUser->cabang_id;
        
        if($data->role_id == 2){
            $adminCount = User::whereHas('Role', function ($query) use($cabangId){
                $query->where('nama_role', 'Admin')
                ->where('cabang_id', $cabangId);
            })->count();
    
    
            if ($adminCount <= 1) {
                return redirect()->route('admin.user.index')->with('error', 'Tidak dapat melakukan update pada akun admin terakhir.');
            }
        }

        $existingUser = User::where('email', $request->email)
        ->where('cabang_id', $cabangId)
        ->where('id', '!=', $id)
        ->first();
    
    $existingno = User::where('no_pegawai', $request->no_pegawai)
        ->where('cabang_id', $cabangId)
        ->where('id', '!=', $id)
        ->first();
    
     if ($existingUser) {
                // Jika email sudah ada, tampilkan pesan flash error
                $request->session()->flash('error', 'Gagal menyimpan data, email sudah terdaftar.');
                return redirect(route('admin.user.index'));
            }
    
            if ($existingno) {
                // Jika email sudah ada, tampilkan pesan flash error
                $request->session()->flash('error', 'Gagal menyimpan data, no pegawai sudah terdaftar.');
                return redirect(route('admin.user.index'));
            }

      
   
        $data->role_id = $request->role_id;
        $data->cabang_id = $loggedInUser->cabang_id;
        $data->nama_user = $request->nama_user;
        $data->no_pegawai = $request->no_pegawai;
        $data->email = $request->email;
        $data->updated_by = $loggedInUsername;
        $isApproval = $request->has('flexCheckIndeterminate');
        
        $data->is_approval = $isApproval;
       
        $data->save();
    
        $request->session()->flash('success', "Akun User berhasil diupdate.");
    
        return redirect(route('admin.user.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        $user = User::find($id);

        if($user->is_approval ==1){

            if (File::where('user_approval', $user->id)->where('status_persetujuan', ['Disetujui'])->exists()){
                $user->is_active = 0;
                $user->save();

                $request->session()->flash('error', "User tidak dihapus namun dinonaktifkan, karena ada file approval yang berhubungan.");
                return redirect()->route('superadmin.user.index');
            } elseif (File::where('user_approval', $user->id)->whereIn('status_persetujuan', ['Menunggu Persetujuan', 'Ditolak'])->exists()){
                $request->session()->flash('error', "Tidak dapat menghapus user, karena masih ada data approval yang berhubungan.");
                return redirect()->route('superadmin.user.index');
            }


        }
        

        if($user->role_id == 1){
        if ($user->Role->nama_role === 'Super Admin') {
            if ($user->id === Auth::id()) {
                return redirect()->route('superadmin.user.index')->with('error', 'Tidak dapat menghapus akun anda sendiri.');
            }

            $adminCount = User::whereHas('Role', function ($query) {
                $query->where('nama_role', 'Super Admin');
            })->count();

            if ($adminCount <= 1) {
                return redirect()->route('superadmin.user.index')->with('error', 'Tidak dapat menghapus akun superadmin terakhir.');
            }
        }

        if (DetailMember::where('user_id', $user->id)->exists()) {
            $request->session()->flash('error', "Tidak dapat menghapus user, karena masih ada data user group yang berhubungan.");
            return redirect()->route('superadmin.user.index');
        }


      

    }

 
    
        $user->delete();

        $request->session()->flash('error', "Akun User berhasil dihapus.");

        return redirect()->route('superadmin.user.index');
    }

    public function aktifkanuser(Request $request ,$id){
        $user = User::find($id);
        $user->is_active = 1;
        $user->save();
        $request->session()->flash('success', "Akun User berhasil diaktifkan kembali.");

        return redirect()->route('superadmin.user.index');
    }

    public function adminaktifkanuser(Request $request ,$id){
        $user = User::find($id);
        $user->is_active = 1;
        $user->save();
        $request->session()->flash('success', "Akun User berhasil diaktifkan kembali.");

        return redirect()->route('admin.user.index');
    }

    public function userdestroy(Request $request, $id)
    {
        $user = User::find($id);

        if($user->is_approval ==1){

            if (File::where('user_approval', $user->id)->where('status_persetujuan', ['Disetujui'])->exists()){
                $user->is_active = 0;
                $user->save();

                $request->session()->flash('error', "User tidak dihapus namun dinonaktifkan, karena ada file approval yang berhubungan.");
                return redirect()->route('superadmin.user.index');
            } elseif (File::where('user_approval', $user->id)->whereIn('status_persetujuan', ['Menunggu Persetujuan', 'Ditolak'])->exists()){
                $request->session()->flash('error', "Tidak dapat menghapus user, karena masih ada data approval yang berhubungan.");
                return redirect()->route('superadmin.user.index');
            }


        }
        if($user->role_id == 2){
        if ($user->Role->nama_role === 'Admin') {
            if ($user->id === Auth::id()) {
                return redirect()->route('admin.user.index')->with('error', 'Tidak dapat menghapus akun anda sendiri.');
            }

            $adminCount = User::whereHas('Role', function ($query) {
                $query->where('nama_role', 'Admin');
            })->count();

            if ($adminCount <= 1) {
                return redirect()->route('admin.user.index')->with('error', 'Tidak dapat menghapus akun admin terakhir.');
            }
        }
        if (DetailMember::where('user_id', $user->id)->exists()) {
            $request->session()->flash('error', "Tidak dapat menghapus user, karena masih ada data user group yang berhubungan.");
            return redirect()->route('admin.user.index');
        }
    }
        $user->delete();

        $request->session()->flash('error', "Akun User berhasil dihapus.");
        
        return redirect()->route('admin.user.index');
    }

    public function resetPassword(User $user, Request $request)
{

    $loggedInUser = Auth::user();
    $loggedInUsername = $loggedInUser->nama_user; 
    
    $user->update([
        'updated_by'=> $loggedInUsername,
        'password' => Hash::make('12345678'), 
    ]);
   
    $request->session()->flash('success', 'Password berhasil direset.');

    return redirect()->route('superadmin.user.index');
    
}   

public function userresetPassword(User $user, Request $request)
{

    $loggedInUser = Auth::user();
    $loggedInUsername = $loggedInUser->nama_user; 
    $user->update([
        'updated_by'=> $loggedInUsername,
        'password' => Hash::make('12345678'), // Ganti 'password_awal' dengan password yang Anda inginkan
    ]);

    $request->session()->flash('success', 'Password berhasil direset.');

    return redirect()->route('admin.user.index');
}

}
