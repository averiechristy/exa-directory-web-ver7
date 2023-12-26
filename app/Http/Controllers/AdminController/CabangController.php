<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use App\Models\Cabang;
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
        Cabang::create([
            'kode_cabang'=> $request->kode_cabang,
            'nama_cabang'=> $request->nama_cabang,
           
            
            
            
        ]);
    
        $request->session()->flash('success', 'User Role berhasil ditambahkan.');
    
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

        $data->kode_cabang    = $request->kode_cabang;
        $data->nama_cabang = $request->nama_cabang;
        

       
 
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

        $cabang->delete();
        
        $request->session()->flash('error', "Cabang berhasil dihapus.");
        
        return redirect()->route('superadmin.cabang.index');
    }
}
