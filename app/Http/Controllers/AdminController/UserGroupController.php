<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use App\Models\Cabang;
use App\Models\DetailMember;
use App\Models\User;
use App\Models\UserGroup;
use Auth;
use Illuminate\Http\Request;

class UserGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $usergroup = UserGroup::orderBy('created_at', 'desc')->get();
        return view("superadmin.usergroup.index", [
            "usergroup"=> $usergroup
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
            $cabang = Cabang::all();
            $users = User::where('role_id', '3')->get();
        
            return view("superadmin.usergroup.create",[
                "cabang"=> $cabang,
                "users"=> $users,
            ]);
    }

    
    public function usergroupindex()
    {
        $cabang = Auth::user()->cabang_id;
    
        // Menyaring data berdasarkan role pengguna
        $usergroup = UserGroup::join('detail_members', 'user_groups.id', '=', 'detail_members.user_group_id')
            ->where('detail_members.cabang_id', $cabang)
            ->orderBy('user_groups.created_at', 'desc')
            ->get(['user_groups.*']); // Ambil semua kolom dari tabel usergroups
    
            
        return view("admin.usergroup.index", [
            "usergroup" => $usergroup
        ]);
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function usergroupcreate()
    {
           
            $loggedInUser = Auth::user();

            // Fetch users with the same cabang_id as the logged-in user
            $users = User::where('role_id', '3')
                          ->where('cabang_id', $loggedInUser->cabang_id)
                          ->get();
        
            return view("admin.usergroup.create",[
               
                "users"=> $users,
            ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $usergroup = new UserGroup;
    $usergroup->nama_group = $request->nama_group;
    $usergroup->save();

    $detailmember = [];

    if ($request->has('anggota')) {
        foreach ($request->anggota as $index => $anggotaId) {
            // Ambil informasi cabang_id dari user_id
            $user = User::find($anggotaId);
            $cabangId = $user->cabang_id;

            $detailmember[] = [
                'user_group_id' => $usergroup->id,
                'user_id' => $anggotaId,
                'cabang_id' => $cabangId, // Tambahkan cabang_id ke array
            ];
        }

        DetailMember::insert($detailmember);
    }


    $request->session()->flash('success', 'User Group berhasil ditambahkan.');
    return redirect(route('superadmin.usergroup.index'));
}


    public function usergroupstore(Request $request)
    {

        $usergroup = new UserGroup;
        $loggedInUser = Auth::user();
        $usergroup->nama_group = $request->nama_group;
      
        $usergroup->save();
    
        $detailmember = [];

        
   
        if ($request->has('anggota') ) {
            foreach ($request->anggota as $index => $anggotaId) {
                $detailmember[] = [
                    'user_group_id' => $usergroup->id,
                    'user_id' => $anggotaId,
                    'cabang_id' => $loggedInUser->cabang_id,

                ];
            }
    
           DetailMember::insert($detailmember); // Simpan array packageDetails secara massal
        }
        
        
    $request->session()->flash('success', 'User Group berhasil ditambahkan.');
    return redirect(route('admin.usergroup.index'));
    }


    public function detailmember($id) {

        $data = UserGroup::find($id);

        
        $member = DetailMember::with('User')->where('user_group_id', $id)->get();
        
        return view('superadmin.usergroup.detail', [
            'data'=> $data,
            'member'=> $member
        ]);
    }

    public function usergroupdetailmember($id) {

        $data = UserGroup::find($id);

        
        $member = DetailMember::with('User')->where('user_group_id', $id)->get();
        
        return view('admin.usergroup.detail', [
            'data'=> $data,
            'member'=> $member
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = UserGroup::find($id); 
        $cabang = Cabang::all();
        $users = User::where('role_id', '3')->get();
        $nama = DetailMember::with('User')->where('user_group_id', $id)->get();

        $selectedCabangs = $nama->pluck('cabang_id')->toArray();

     
        return view('superadmin.usergroup.edit', [
            'data'=> $data,
            'cabang'=> $cabang,
            'users'=> $users,
            'nama'=> $nama,
            'selectedCabangs' => $selectedCabangs,
        ]);
    }

    public function usergroupshow(string $id)
    {
        $data = UserGroup::find($id); 
        
        $loggedInUser = Auth::user();
        $users = User::where('role_id', '3')
        ->where('cabang_id', $loggedInUser->cabang_id)
        ->get();        

        
        $nama = DetailMember::with('User')->where('user_group_id', $id)->get();
        

        return view('admin.usergroup.edit', [
            'data'=> $data,
            
            'users'=> $users,
            'nama'=> $nama
        ]);
    }
    
    
    public function getMembersByCabang($cabangId)
    {
        // Fetch members based on the selected branch (Cabang)
        $members = User::whereIn('cabang_id', $cabangId)->get();

        return response()->json(['members' => $members]);
    }

    public function getAnggotaByCabang(Request $request)
{
    $cabangIds = $request->input('cabang');
    
    // Mendapatkan anggota berdasarkan cabang yang di-check
    $anggota = User::whereIn('cabang_id', $cabangIds)->get();

    return response()->json($anggota);
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
    public function update(Request $request, $id)
    {
        // Validate the request data
        $request->validate([
            'nama_group' => 'required|string|max:255',
            'cabang' => 'required|array',
            'anggota' => 'required|array',
        ]);
    
        // Update UserGroup
        $usergroup = UserGroup::findOrFail($id);
        $usergroup->nama_group = $request->nama_group;
        $usergroup->save();
    
        // Update or create DetailMember records
        $detailmember = [];
    
        foreach ($request->anggota as $index => $anggotaId) {
            $user = User::find($anggotaId);
            $cabangId = $user->cabang_id;
    
            $detailmember[] = [
                'user_group_id' => $usergroup->id,
                'user_id' => $anggotaId,
                'cabang_id' => $cabangId,
            ];
        }
    
        // Delete existing DetailMember records for the user group
        DetailMember::where('user_group_id', $usergroup->id)->delete();
    
        // Insert updated DetailMember records
        DetailMember::insert($detailmember);
    
        // Flash success message and redirect
        $request->session()->flash('success', 'User Group berhasil diupdate.');
        return redirect()->route('superadmin.usergroup.index');
    }
    

        public function usergroupupdate(Request $request, string $id)
        {
            $selectedProductsArray = $request->input('anggota');
    
            // Simpan data produk yang dipilih ke dalam session
            $request->session()->put('selected_products', $selectedProductsArray);
               // Ambil data paket berdasarkan ID
            $dtPackage = UserGroup::find($id);
            $loggedInUser = Auth::user();
            // Update data paket dengan nilai baru dari form
            $dtPackage->nama_group = $request->nama_group;
        
            
            $dtPackage->save();
        
        
            // Hapus detail paket yang ada sebelumnya
            DetailMember::where('user_group_id', $id)->delete();
        
            // Simpan detail paket yang baru
            $usergroup = [];
        
            if ($request->has('anggota')) {
                foreach ($request->anggota as $index => $anggotaId) {
                    $usergroup[] = [
                        'user_group_id' => $dtPackage->id,
                        'user_id' => $anggotaId, // Gunakan $productId langsung sebagai produk_id
                        'cabang_id' => $loggedInUser->cabang_id,
                    ];
                }
        
                // dd($packageDetails);
            
                 // Simpan array packageDetails secara massal
            }
            
            DetailMember::where('user_group_id', $dtPackage->id)->delete();
            DetailMember::insert($usergroup);
        
                $request->session()->flash('success', 'User Group berhasil diupdate.');
                return redirect(route('admin.usergroup.index'));
            
            }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        // Temukan UserGroup yang akan dihapus
        $usergroup = UserGroup::find($id);
    
        // Periksa jika UserGroup ditemukan
        if ($usergroup) {
            // Temukan DetailMember yang memiliki user_group_id yang sama dengan UserGroup yang akan dihapus
            $detailMembers = DetailMember::where('user_group_id', $usergroup->id)->get();
    
            // Hapus semua DetailMember yang ditemukan
            foreach ($detailMembers as $detailMember) {
                $detailMember->delete();
            }
    
            // Hapus UserGroup setelah menghapus DetailMember
            $usergroup->delete();
    
            // Set flash message
            $request->session()->flash('error', "User Group Berhasil dihapus.");
        } else {
            // Jika UserGroup tidak ditemukan, set flash message sesuai kebutuhan
            $request->session()->flash('error', "User Group tidak ditemukan.");
        }
    
        // Redirect ke halaman index
        return redirect(route('superadmin.usergroup.index'));
    }
    

    
    public function usergroupdestroy(Request $request, $id)
    {
    $usergroup = UserGroup::find($id);
    $usergroup->delete();

    $request->session()->flash('error', "User Group Berhasil dihapus.");

    return redirect(route('admin.usergroup.index'));
}

}
