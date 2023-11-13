<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use App\Models\Cabang;
use App\Models\DetailMember;
use App\Models\User;
use App\Models\UserGroup;
use Illuminate\Http\Request;

class UserGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $usergroup = UserGroup::orderBy('created_at', 'desc')->get();
        return view("admin.usergroup.index", [
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
        
            return view("admin.usergroup.create",[
                "cabang"=> $cabang,
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
        $usergroup->cabang_id = $request->cabang_id;
      
        $usergroup->save();
    
        $detailmember = [];

        
    
        if ($request->has('anggota') ) {
            foreach ($request->anggota as $index => $anggotaId) {
                $detailmember[] = [
                    'user_group_id' => $usergroup->id,
                    'user_id' => $anggotaId,
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

        return view('admin.usergroup.edit', [
            'data'=> $data,
            'cabang'=> $cabang,
            'users'=> $users,
            'nama'=> $nama
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
        $selectedProductsArray = $request->input('anggota');

        // Simpan data produk yang dipilih ke dalam session
        $request->session()->put('selected_products', $selectedProductsArray);
           // Ambil data paket berdasarkan ID
        $dtPackage = UserGroup::find($id);
      
        // Update data paket dengan nilai baru dari form
        $dtPackage->nama_group = $request->nama_group;
        $dtPackage->cabang_id = $request->cabang_id;
    
        
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
                ];
            }
    
            // dd($packageDetails);
        
            DetailMember::insert($usergroup); // Simpan array packageDetails secara massal
        }
        
    
            $request->session()->flash('success', 'User Group berhasil diupdate.');
            return redirect(route('admin.usergroup.index'));
        
        }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
        {
        $usergroup = UserGroup::find($id);
        $usergroup->delete();

        $request->session()->flash('error', "User Group Berhasil dihapus.");

        return redirect(route('admin.usergroup.index'));
    }
}
