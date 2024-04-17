<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use App\Models\Cabang;
use App\Models\DetailGroup;
use App\Models\DetailMember;
use App\Models\File;
use App\Models\User;
use Illuminate\Http\Request;

class CabangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cabang =Cabang::orderBy('created_at', 'desc')->get();
        return view("superadmin.cabang.index",[
            "cabang"=> $cabang
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("superadmin.cabang.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $loggedInUser = auth()->user();
        $loggedInUsername = $loggedInUser->nama_user; 

        $namacabang = $request->nama_cabang;
        $kodecabang = $request -> kode_cabang;

        $existingcode = Cabang::where('kode_cabang',$kodecabang)->first();
        $existingnama = Cabang::where('nama_cabang',$namacabang)->first();

        if($existingcode){
            $request->session()->flash('error', "Gagal menyimpan data, kode cabang sudah ada.");
        
            return redirect()->route('superadmin.cabang.index');
        }
        if ($existingnama){

            $request->session()->flash('error', "Gagal menyimpan data, nama cabang sudah ada.");
        
            return redirect()->route('superadmin.cabang.index');


        }

        Cabang::create([
            'kode_cabang'=> $request->kode_cabang,
            'nama_cabang'=> $request->nama_cabang,
           'created_by' => $loggedInUsername,
            
        ]);
    
        $request->session()->flash('success', 'Cabang berhasil ditambahkan.');
    
        return redirect(route('superadmin.cabang.index'));   
    }


    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Cabang::find($id);

        return view('superadmin.cabang.edit',[
            'data'=> $data
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
        $data = Cabang::find($id);
        $loggedInUser = auth()->user();
        $loggedInUsername = $loggedInUser->nama_user; 



        $namacabang = $request->nama_cabang;
        $kodecabang = $request -> kode_cabang;

        $existingcode = Cabang::where('kode_cabang',$kodecabang)->first();
        $existingnama = Cabang::where('nama_cabang',$namacabang)->first();

        if($existingcode){
            $request->session()->flash('error', "Gagal menyimpan data, kode cabang sudah ada.");
        
            return redirect()->route('superadmin.cabang.index');
        }
        if ($existingnama){

            $request->session()->flash('error', "Gagal menyimpan data, nama cabang sudah ada.");
        
            return redirect()->route('superadmin.cabang.index');


        }

        $data->fill($request->except('kode_cabang'));
        $kode_cabang_existing = $data->kode_cabang;
        // Mengatur kode cabang kembali ke nilai yang ada sebelumnya
        $data->kode_cabang = $kode_cabang_existing;
            $data->nama_cabang = $request->nama_cabang;
        $data->updated_by = $loggedInUsername;

       
 
        $data->save();
        $request->session()->flash('success', "Cabang berhasil diupdate.");
        return redirect(route('superadmin.cabang.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        $cabang = Cabang::find($id);
        
        
        if (User::where('cabang_id', $cabang->id)->exists()) {
            $request->session()->flash('error', "Tidak dapat menghapus cabang, karena masih ada data user account yang berhubungan.");
            return redirect()->route('superadmin.cabang.index');
        }

        if (File::where('cabang_id_user', $cabang->id)->exists()) {
            $request->session()->flash('error', "Tidak dapat menghapus cabang, karena masih ada data File yang berhubungan.");
            return redirect()->route('superadmin.cabang.index');
        }

        if (DetailMember::where('cabang_id', $cabang->id)->exists()) {
            $request->session()->flash('error', "Tidak dapat menghapus cabang, karena masih ada data Member Group yang berhubungan.");
            return redirect()->route('superadmin.cabang.index');
        }

        if (DetailGroup::where('cabang_id', $cabang->id)->exists()) {
            $request->session()->flash('error', "Tidak dapat menghapus cabang, karena masih ada data Group yang berhubungan.");
            return redirect()->route('superadmin.cabang.index');
        }

        $cabang->delete();
        
        $request->session()->flash('error', "Cabang berhasil dihapus.");
        
        return redirect()->route('superadmin.cabang.index');
    }
}
