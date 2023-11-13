<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use App\Models\DetailGroup;
use App\Models\Folder;
use App\Models\UserGroup;
use Illuminate\Http\Request;

class FolderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $folders = Folder::orderBy('created_at', 'desc')->get();
        return view("admin.folder.index",[
            "folders"=> $folders
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $usergroup = UserGroup::all();
        return view("admin.folder.create",[
            "usergroup"=> $usergroup
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $folder = new Folder;
        $folder->nama_folder = $request->nama_folder;
      
        $folder->save();
    
        $detailGroup = [];

        
    
        if ($request->has('group') ) {
            foreach ($request->group as $index => $groupId) {
                $detailGroup[] = [
                    'user_group_id' => $groupId,
                    'folder_id' => $folder->id,
                    
                ];
            }
    
           DetailGroup::insert($detailGroup); // Simpan array packageDetails secara massal
        }
        
    $request->session()->flash('success', 'Folder berhasil ditambahkan.');
    return redirect(route('admin.folder.index'));
    }


    public function detailgroup($id) {

        $data = Folder::find($id);

        
        $group = DetailGroup::with('Folder')->where('folder_id', $id)->get();
        
        return view('admin.folder.detail', [
            'data'=> $data,
            'group'=> $group
        ]);
    }

    public function rename(Request $request, $id)
{
    // Validasi data yang diterima dari formulir
    $request->validate([
        'new_folder_name' => 'required|string|max:255',
    ]);

    // Temukan folder berdasarkan ID
    $folder = Folder::find($id);

    if (!$folder) {
        return redirect()->back()->with('error', 'Folder not found.');
    }

    // Ubah nama folder
    $folder->nama_folder = $request->input('new_folder_name');
    $folder->save();

    $request->session()->flash('success', 'Folder berhasil direname.');
    return redirect(route('admin.folder.index'));
}

    public function addFolder(Request $request)
    {
        // Validasi data yang dikirimkan
        Folder::create([
            'nama_folder' => $request->input('nama_folder'),
          // Jika Anda ingin menyimpan ID pengguna yang membuat folder.
        ]);
    
        return redirect()->route('admin.folder.index')
            ->with('success', 'Folder berhasil ditambahkan.');
    }

    public function delete($id, Request $request)
{
    // Temukan folder berdasarkan ID
    $folder = Folder::find($id);

    if (!$folder) {
        return redirect()->route('your.index.route')->with('error', 'Folder not found.');
    }

    // Hapus folder dari database
    $folder->delete();

    $request->session()->flash('success', 'Folder berhasil dihapus.');
    return redirect(route('admin.folder.index'));
}

public function createSubfolder(Request $request, $id)
{
    // Validasi request
    $request->validate([
        'nama_subfolder' => 'required|string|max:255', // Sesuaikan dengan kebutuhan validasi
    ]);

    // Temukan folder utama
    $parentFolder = Folder::find($id);

    // Buat subfolder
    $subfolder = new Folder([
        'id_folder_induk' => $parentFolder->id,
        'nama_folder' => $request->input('nama_subfolder'),
        'created_by' => auth()->id(), // Sesuaikan dengan cara Anda menyimpan informasi pembuat folder
    ]);

    $subfolder->save();

    $request->session()->flash('success', 'Subfolder berhasil dibuat.');
    return redirect(route('admin.folder.index'));}
    

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
