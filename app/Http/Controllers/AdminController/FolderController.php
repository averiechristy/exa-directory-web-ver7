<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use App\Models\DetailGroup;
use App\Models\DetailMember;
use App\Models\Folder;
use App\Models\UserGroup;
use Auth;
use Illuminate\Http\Request;

class FolderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $folders = Folder::whereNull('id_folder_induk')->orderBy('created_at', 'desc')->get();       
        $usergroup = UserGroup::all();

        
        return view("superadmin.folder.index",[
            "folders"=> $folders,
            "usergroup"=> $usergroup
        ]);
    }

    public function folderindex()
{
    // Mendapatkan ID cabang dari user login
    
    $Cabang = Auth::user()->cabang_id;
    $usergroup = DetailMember::where('cabang_id', $Cabang)->get();
    $cabangId = auth()->user()->cabang_id;

    // Menggunakan join untuk mengambil data folder berdasarkan user_group_id yang sesuai dengan cabang_id
    // $folders = Folder::join('detail_groups', 'detail_groups.folder_id', '=', 'folders.id')
    // ->where('detail_groups.cabang_id', $Cabang)
    // ->whereNull('id_folder_induk')
    // ->orderBy('folders.created_at', 'desc')
    // ->get(); 
    
    
    
    $folders = Folder::join('detail_groups', 'folders.id', '=', 'detail_groups.folder_id')
    ->where('detail_groups.cabang_id', $Cabang)
    ->whereNull('id_folder_induk')
    ->orderBy('detail_groups.created_at', 'desc')
    ->select('folders.*') // Ambil semua kolom dari tabel usergroups
    ->distinct('detail_groups.id', 'detail_groups.cabang_id')
    ->get();



   
    
    return view("admin.folder.index", [
        "folders" => $folders,
        "usergroup"=> $usergroup
    ]);
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $usergroup = UserGroup::all();
        return view("superadmin.folder.create",[
            "usergroup"=> $usergroup
        ]);
    }

    public function foldercreate()
    {
        $cabang = Auth::user()->cabang_id;
    
        // Menyaring data berdasarkan role pengguna
        $usergroup = UserGroup::join('detail_members', 'user_groups.id', '=', 'detail_members.user_group_id')
            ->where('detail_members.cabang_id', $cabang)
            ->orderBy('user_groups.created_at', 'desc')
            ->get(['user_groups.*']);

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

    if ($request->has('group')) {
        foreach ($request->group as $index => $groupId) {
            // Ambil semua cabang_id dari DetailMember yang sesuai dengan user_group_id
            $cabangIds = DetailMember::where('user_group_id', $groupId)->pluck('cabang_id')->toArray();

            foreach ($cabangIds as $cabangId) {
                $detailGroup[] = [
                    'user_group_id' => $groupId,
                    'folder_id' => $folder->id,
                    'cabang_id' => $cabangId,
                ];
            }
        }

        DetailGroup::insert($detailGroup);
    }

    $request->session()->flash('success', 'Folder berhasil ditambahkan.');
    return redirect(route('superadmin.folder.index'));
}

    

    public function folderstore(Request $request)
    {
        $folder = new Folder;
        $loggedInUser = Auth::user();
       
        $folder->nama_folder = $request->nama_folder;
    
        // Ambil group dari request
      
        $folder->save();
        $detailgroup = [];

        
   
        if ($request->has('group') ) {
            foreach ($request->group as $index => $groupId) {
                $detailgroup[] = [
                    'folder_id' => $folder->id, // Corrected column name to 'folder_id'
                    'user_group_id' => $groupId,
                    'cabang_id' => $loggedInUser->cabang_id,
                ];
            }
            
    
           DetailGroup::insert($detailgroup); // Simpan array packageDetails secara massal
        }
        
    
        $request->session()->flash('success', 'Folder berhasil ditambahkan.');
        return redirect(route('admin.folder.index'));
    }
    


    public function detailgroup($id) {

        $data = Folder::find($id);

        
        $group = DetailGroup::with('Folder')->where('folder_id', $id)->get();
        
        return view('superadmin.folder.detail', [
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

public function renameadmin(Request $request, $id)
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
    $folder = new Folder;
    $folder->nama_folder = $request->nama_folder;
  
    $folder->save();

    $detailgroup = [];

    if ($request->has('group')) {
        foreach ($request->group as $index => $groupId) {
            $detailgroup[] = [
                'folder_id' => $folder->id,
                'user_group_id' => $groupId,
            ];
        }

        // Simpan detail group secara massal
        DetailGroup::insert($detailgroup);
    }

    dd($detailgroup);

    return redirect()->route('superadmin.folder.index')
        ->with('success', 'Folder berhasil ditambahkan.');
}



public function delete($id, Request $request)
{
    // Temukan folder berdasarkan ID
    $folder = Folder::find($id);

    if (!$folder) {
        return redirect()->route('superadmin.folder.index')->with('error', 'Folder not found.');
    }

    // Temukan DetailGroup yang memiliki folder_id yang sama dengan Folder yang akan dihapus
    $detailGroups = DetailGroup::where('folder_id', $folder->id)->get();

    // Hapus semua DetailGroup yang ditemukan
    foreach ($detailGroups as $detailGroup) {
        $detailGroup->delete();
    }

    // Hapus folder dari database setelah menghapus DetailGroup
    $folder->delete();

    // Set flash message
    $request->session()->flash('success', 'Folder berhasil dihapus.');
    return redirect(route('superadmin.folder.index'));
}


public function deleteadmin($id, Request $request)
{
    // Temukan folder berdasarkan ID
    $folder = Folder::find($id);

    if (!$folder) {
        return redirect()->route('admin.folder.index')->with('error', 'Folder not found.');
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
 
    $userGroupId = $parentFolder->user_group_id;

    // Buat subfolder
    $subfolder = new Folder([
        'id_folder_induk' => $parentFolder->id,
        'nama_folder' => $request->input('nama_subfolder'),
        'user_group_id' => $userGroupId,
        // Sesuaikan dengan cara Anda menyimpan informasi pembuat folder
    ]);

    $subfolder->save();

    // Ambil semua cabang_id dari parent folder
    $cabangIds = DetailGroup::where('folder_id', $parentFolder->id)->pluck('cabang_id')->toArray();

    // Simpan ke dalam detail_groups
    $detailGroups = [];

    foreach ($cabangIds as $cabangId) {
        $detailGroups[] = [
            'user_group_id' => $userGroupId,
            'folder_id' => $subfolder->id,
            'cabang_id' => $cabangId,
        ];
    }

    DetailGroup::insert($detailGroups);

    $request->session()->flash('success', 'Subfolder berhasil dibuat.');
    return redirect(route('superadmin.folder.index'));
}



public function createSubfolderadmin(Request $request, $id)
{
    // Validasi request
    $request->validate([
        'nama_subfolder' => 'required|string|max:255', // Sesuaikan dengan kebutuhan validasi
    ]);

    // Temukan folder utama
    $parentFolder = Folder::find($id);
 
    $userGroupId = $parentFolder->user_group_id;

    $cabangId  = $parentFolder->cabang_id;
    

    // Buat subfolder
    $subfolder = new Folder([
        'id_folder_induk' => $parentFolder->id,
        'nama_folder' => $request->input('nama_subfolder'),
        'user_group_id' => $userGroupId,
        'cabang_id' => $cabangId,
       // Sesuaikan dengan cara Anda menyimpan informasi pembuat folder
    ]);

    $subfolder->save();

    

    $request->session()->flash('success', 'Subfolder berhasil dibuat.');
    return redirect(route('admin.folder.index'));
}

// public function getFolderData($id)
// {
//     $folder = Folder::find($id);
//     $group = UserGroup::all();

//     // You can fetch additional data or modify this based on your requirements

//     return response()->json([
//         'folder' => $folder,
//         'group'=> $group
//     ]);
// }

public function getGroupData($folderId)
{
    // Lakukan query atau logika lainnya untuk mendapatkan data grup berdasarkan $folderId
    $groupData = UserGroup::find($folderId);

    // Mengembalikan data dalam format JSON
    return response()->json(['groupName' => $groupData->nama_group, 'otherData' => $groupData->otherAttribute]);
}

public function tampilfoldergroup ($id) {

    $folder = Folder::find($id);
    $usergroup = UserGroup::all();

    $nama = DetailGroup::with('UserGroup')->where('folder_id', $id)->get();
   
    $selectedGroup = $nama->pluck('user_group_id')->toArray();


   
    return view('superadmin.folder.showgroup',[
        'folder'=> $folder,
       'nama' => $nama,
       'usergroup'=> $usergroup,
       'selectedGroup' => $selectedGroup,
    ]);
}

public function tampilfoldergroupadmin ($id) {

    $folder = Folder::find($id);
    $cabang = Auth::user()->cabang_id;
    
        // Menyaring data berdasarkan role pengguna
        $usergroup = UserGroup::join('detail_members', 'user_groups.id', '=', 'detail_members.user_group_id')
            ->where('detail_members.cabang_id', $cabang)
            ->orderBy('user_groups.created_at', 'desc')
            ->get(['user_groups.*']);
    $nama = DetailGroup::with('UserGroup')->where('folder_id', $id)->get();
   
    $selectedGroup = $nama->pluck('user_group_id')->toArray();


   
    return view('admin.folder.showgroup',[
        'folder'=> $folder,
       'nama' => $nama,
       'usergroup'=> $usergroup,
       'selectedGroup' => $selectedGroup,
    ]);
}

public function updatefoldergroup(Request $request, $id) {
   
  
    

    $folder = Folder::findOrFail($id);
    $folder->nama_folder = $request->nama_folder;
    $folder->save();

    // Delete existing details related to this folder
    DetailGroup::where('folder_id', $folder->id)->delete();

    $detailGroup = [];

    if ($request->has('cabang')) {
        foreach ($request->cabang as $groupId) {
            // Assuming 'cabang' is the correct name
            // Ambil semua cabang_id dari DetailMember yang sesuai dengan user_group_id
            $cabangIds = DetailMember::where('user_group_id', $groupId)->pluck('cabang_id')->toArray();

            foreach ($cabangIds as $cabangId) {
                $detailGroup[] = [
                    'user_group_id' => $groupId,
                    'folder_id' => $folder->id,
                    'cabang_id' => $cabangId,
                ];
            }
        }

        DetailGroup::insert($detailGroup);
    }

    $request->session()->flash('success', 'Folder berhasil diupdate.');
    return redirect(route('superadmin.folder.index'));
}


public function updatefoldergroupadmin(Request $request, $id) {
   
  
    

    $folder = Folder::findOrFail($id);
    $folder->nama_folder = $request->nama_folder;
    $folder->save();

    // Delete existing details related to this folder
    DetailGroup::where('folder_id', $folder->id)->delete();

    $detailGroup = [];

    if ($request->has('cabang')) {
        foreach ($request->cabang as $groupId) {
            // Assuming 'cabang' is the correct name
            // Ambil semua cabang_id dari DetailMember yang sesuai dengan user_group_id
            $cabangIds = DetailMember::where('user_group_id', $groupId)->pluck('cabang_id')->toArray();

            foreach ($cabangIds as $cabangId) {
                $detailGroup[] = [
                    'user_group_id' => $groupId,
                    'folder_id' => $folder->id,
                    'cabang_id' => $cabangId,
                ];
            }
        }

        DetailGroup::insert($detailGroup);
    }

    $request->session()->flash('success', 'Folder berhasil diupdate.');
    return redirect(route('admin.folder.index'));
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
