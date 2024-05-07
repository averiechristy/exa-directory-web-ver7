<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\DetailGroup;
use App\Models\DetailMember;
use App\Models\File;
use App\Models\Folder;
use App\Models\Pin;
use App\Models\User;
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

        if (auth()->user()->cabang_id == 1){
        $folders = Folder::whereNull('id_folder_induk')->orderBy('created_at', 'desc')->get();       
        $usergroup = UserGroup::all();
        }
        else {
            $Cabang = Auth::user()->cabang_id;
            $role = Auth::user()->role_id;
        
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
        }

        
        return view("superadmin.folder.index",[
            "folders"=> $folders,
            "usergroup"=> $usergroup
        ]);
    }

    public function folderindex()
{
    // Mendapatkan ID cabang dari user login
    
    $Cabang = Auth::user()->cabang_id;
    $role = Auth::user()->role_id;

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

    

    
    // $folders = Folder::where('cabang_id', $Cabang)->whereNull('id_folder_induk')
    // ->where('role_id', $role)
    // ->get();

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
        if (auth()->user()->cabang_id == 1) {
        $usergroup = UserGroup::all();
        }
        else {
            $cabang = Auth::user()->cabang_id;
            $role = Auth::user()->role_id;
        
            // Menyaring data berdasarkan role pengguna
            $usergroup = UserGroup::join('detail_members', 'user_groups.id', '=', 'detail_members.user_group_id')
             ->where('detail_members.cabang_id', $cabang)
             ->orderBy('user_groups.created_at', 'desc')
             ->distinct()
             ->get(['user_groups.*']); 
        }
        
        return view("superadmin.folder.create",[
            "usergroup"=> $usergroup
        ]);
    }

    public function foldercreate()
    {
       
        // Menyaring data berdasarkan role pengguna
        // $usergroup = UserGroup::join('detail_members', 'user_groups.id', '=', 'detail_members.user_group_id')
        //     ->where('detail_members.cabang_id', $cabang)
        //     ->orderBy('user_groups.created_at', 'desc')
        //     ->get(['user_groups.*']);

        // $cabang = Auth::user()->cabang_id;
        // $role = Auth::user()->role_id;
        // $usergroup = UserGroup::where('cabang_id', $cabang)
      
        // ->get();
        $cabang = Auth::user()->cabang_id;
        $role = Auth::user()->role_id;
    
        // Menyaring data berdasarkan role pengguna
        $usergroup = UserGroup::join('detail_members', 'user_groups.id', '=', 'detail_members.user_group_id')
         ->where('detail_members.cabang_id', $cabang)
         ->orderBy('user_groups.created_at', 'desc')
         ->distinct()
         ->get(['user_groups.*']); 

        return view("admin.folder.create",[
            "usergroup"=> $usergroup
        ]);
    }
    public function getGroupMembers($id) {
        
        $members = DetailMember::with('user')->where('user_group_id', $id)->get();
        return response()->json($members);
    }

    public function getGroupMembersedit($id) {
        
        $members = DetailMember::with('user')->where('user_group_id', $id)->get();
        return response()->json($members);
    }
    public function getGroupMembersadmin($id) {
        
        $members = DetailMember::with('user')->where('user_group_id', $id)->get();
        return response()->json($members);
    }

 
    /**
     * Store a newly created resource in storage.
     */
public function store(Request $request)
{
   
    $Cabang = Auth::user()->cabang_id; 
    $role = Auth::user()->role_id;

    $namafolder = $request -> nama_folder;
   

    $existingfile =  Folder::where('role_id', $role)->where('cabang_id', $Cabang)->where('nama_folder', $namafolder)->whereNull('id_folder_induk')->first();
    
 
    
    if($existingfile){
        
        $request->session()->flash('error', 'Folder gagal ditambahkan, nama folder sudah ada.');
        return redirect(route('superadmin.folder.index'));
    }

    

    $loggedInUser = auth()->user();
    $roleId = $loggedInUser->role_id;
    $loggedInUsername = $loggedInUser->nama_user; 

    if (auth()->user()->cabang_id == 1){
    $folder = new Folder;
    $folder->nama_folder = $request->nama_folder;
    $folder -> cabang_id = $Cabang;
    $folder -> created_by = $loggedInUsername;
    $folder -> role_id = $roleId;


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
}

else {
    $folder = new Folder;
    $loggedInUser = auth()->user();
$loggedInUsername = $loggedInUser->nama_user; 
    $folder->nama_folder = $request->nama_folder;
    $folder -> cabang_id = $Cabang;
    $folder -> created_by = $loggedInUsername;
    // Ambil group dari request
    $roleId = $loggedInUser->role_id;

    $folder -> role_id = $roleId;

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
}
ActivityLog::create([
    'user_id' => Auth::id(),
    'nama_user' =>  Auth::user()->nama_user,
    'activity' => 'Membuat Folder',
    'description' => 'User berhasil membuat folder ' . $request->nama_folder,
    'timestamp' => now(),
    'cabang_id' =>  Auth::user()->cabang_id,
    'role_id' =>  Auth::user()->role_id,
]);

    $request->session()->flash('success', 'Folder berhasil ditambahkan.');
    return redirect(route('superadmin.folder.index'));
}

    

    public function folderstore(Request $request)
    {
       
        $loggedInUser = Auth::user();
        $Cabang = Auth::user()->cabang_id; 

        $role = Auth::user()->role_id;

    $namafolder = $request -> nama_folder;
   

    $existingfile =  Folder::where('cabang_id', $Cabang)->where('nama_folder', $namafolder)->whereNull('id_folder_induk')->first();
    
 
    
    if($existingfile){
        
        $request->session()->flash('error', 'Folder gagal ditambahkan, nama folder sudah ada.');
        return redirect(route('admin.folder.index'));
    }



    $folder = new Folder;
        $loggedInUser = auth()->user();
    $loggedInUsername = $loggedInUser->nama_user; 
        $folder->nama_folder = $request->nama_folder;
        $folder -> cabang_id = $Cabang;
        $folder -> created_by = $loggedInUsername;
        // Ambil group dari request
        $roleId = $loggedInUser->role_id;

        $folder -> role_id = $roleId;

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
        
        ActivityLog::create([
            'user_id' => Auth::id(),
            'nama_user' =>  Auth::user()->nama_user,
            'activity' => 'Membuat Folder',
            'description' => 'User berhasil membuat folder ' . $request->nama_folder,
            'timestamp' => now(),
            'cabang_id' =>  Auth::user()->cabang_id,
            'role_id' =>  Auth::user()->role_id,
        ]);
        $request->session()->flash('success', 'Folder berhasil ditambahkan.');
        return redirect(route('admin.folder.index'));
    }
    


    public function tampilgrup($id) {

        $data = Folder::find($id);

        
        $group = DetailGroup::where('folder_id', $id)->distinct()->pluck('user_group_id');
       
        $namaGroups = [];

        foreach ($group as $userGroupId) {
            $userGroup = UserGroup::find($userGroupId); // Mencari UserGroup berdasarkan user_group_id
            if ($userGroup) {
                $namaGroups[] = $userGroup->nama_group; // Mengumpulkan nama grup
            }
        }

      
        return view('superadmin.folder.detail', [
            'data'=> $data,
            'group'=> $group,
            'namaGroups' => $namaGroups,
        ]);
    }
    public function tampilgrupadmin($id) {

        $data = Folder::find($id);

        
        $group = DetailGroup::where('folder_id', $id)->distinct()->pluck('user_group_id');
       
        $namaGroups = [];

        foreach ($group as $userGroupId) {
            $userGroup = UserGroup::find($userGroupId); // Mencari UserGroup berdasarkan user_group_id
            if ($userGroup) {
                $namaGroups[] = $userGroup->nama_group; // Mengumpulkan nama grup
            }
        }

      
        return view('admin.folder.detail', [
            'data'=> $data,
            'group'=> $group,
            'namaGroups' => $namaGroups,
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

    ActivityLog::create([
        'user_id' => Auth::id(),
        'nama_user' =>  Auth::user()->nama_user,
        'activity' => 'Update Folder',
        'description' => 'User berhasil mengupdate folder ' . $folder->nama_folder,
        'timestamp' => now(),
        'cabang_id' =>  Auth::user()->cabang_id,
        'role_id' =>  Auth::user()->role_id,
    ]);

    $request->session()->flash('success', 'Folder berhasil direname.');
    return redirect(route('superadmin.folder.index'));
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
    ActivityLog::create([
        'user_id' => Auth::id(),
        'nama_user' =>  Auth::user()->nama_user,
        'activity' => 'Update Folder',
        'description' => 'User berhasil mengupdate folder ' . $folder->nama_folder,
        'timestamp' => now(),
        'cabang_id' =>  Auth::user()->cabang_id,
        'role_id' =>  Auth::user()->role_id,
    ]);
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

 
    ActivityLog::create([
        'user_id' => Auth::id(),
        'nama_user' =>  Auth::user()->nama_user,
        'activity' => 'Membuat Folder',
        'description' => 'User berhasil membuat folder ' . $request->nama_folder,
        'timestamp' => now(),
        'cabang_id' =>  Auth::user()->cabang_id,
        'role_id' =>  Auth::user()->role_id,
    ]);
    return redirect()->route('superadmin.folder.index')
        ->with('success', 'Folder berhasil ditambahkan.');
}



public function deleteFolderAndChildren($folder)
{
    // Temukan semua folder anak
    $childFolders = Folder::where('id_folder_induk', $folder->id)->get();

    // Hapus semua folder anak secara rekursif
    foreach ($childFolders as $childFolder) {
        $this->deleteFolderAndChildren($childFolder);
    }

    // Hapus semua DetailGroup terkait dengan folder
    $detailGroups = DetailGroup::where('folder_id', $folder->id)->get();
    foreach ($detailGroups as $detailGroup) {
        // Hapus semua file terkait dengan DetailGroup
       
        // Hapus DetailGroup
        $detailGroup->delete();
    }

    $files = File::where('folder_id', $folder->id)->get();
    foreach ($files as $file) {
        $file->delete();
    }
    // Hapus semua pin terkait dengan folder
    $pins = Pin::where('folder_id', $folder->id)->get();
    
    foreach ($pins as $pin) {
        // Hapus semua file terkait dengan pin
        
        // Hapus pin
        $pin->delete();
    }

    // Hapus folder
    $folder->delete();
}


public function delete($id, Request $request)
{
    // Temukan folder berdasarkan ID
    $folder = Folder::find($id);

    $deletedFolder = $folder->nama_folder;

    if (!$folder) {
        return redirect()->route('superadmin.folder.index')->with('error', 'Folder not found.');
    }

    if (!empty($folder)) {
        Pin::whereIn('folder_id', $folder)->delete();
    }

    // Hapus folder dan semua folder anak secara rekursif
    $this->deleteFolderAndChildren($folder);
    
    ActivityLog::create([
        'user_id' => Auth::id(),
        'nama_user' =>  Auth::user()->nama_user,
        'activity' => 'Hapus Folder',
        'description' => "User berhasil menghapus folder $deletedFolder",
        'timestamp' => now(),
        'cabang_id' =>  Auth::user()->cabang_id,
        'role_id' =>  Auth::user()->role_id,
    ]);
    
    // Set flash message
    $request->session()->flash('error', 'Folder berhasil dihapus.');
    return redirect(route('superadmin.folder.index'));
}



public function deleteadmin($id, Request $request)
{
    // Temukan folder berdasarkan ID
    $folder = Folder::find($id);
    $deletedFolder = $folder->nama_folder;

    if (!$folder) {
        return redirect()->route('admin.folder.index')->with('error', 'Folder not found.');
    }
    $this->deleteFolderAndChildren($folder);
    // Hapus folder dari database
    ActivityLog::create([
        'user_id' => Auth::id(),
        'nama_user' =>  Auth::user()->nama_user,
        'activity' => 'Hapus Folder',
        'description' => "User berhasil menghapus folder $deletedFolder",
        'timestamp' => now(),
        'cabang_id' =>  Auth::user()->cabang_id,
        'role_id' =>  Auth::user()->role_id,
    ]);
    $request->session()->flash('error', 'Folder berhasil dihapus.');
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
    
    $idparent = $parentFolder -> id;

    $detailgrup = DetailGroup::where('folder_id', $idparent)->get();




    $cabangId  = $parentFolder->cabang_id;
    $roleId  = $parentFolder->role_id;

    
    // Buat subfolder
    $subfolder = new Folder([
        'id_folder_induk' => $parentFolder->id,
        'nama_folder' => $request->input('nama_subfolder'),
        
        // Sesuaikan dengan cara Anda menyimpan informasi pembuat folder
        'cabang_id' => $cabangId,
        'role_id' => $roleId,
    ]);

    $subfolder->save();

    // Ambil semua cabang_id dan user_group_id dari parent folder
    $detailGroups = [];

    foreach ($detailgrup as $detail) {
        $detailGroups[] = [
            'folder_id' => $subfolder->id,
            'cabang_id' => $detail->cabang_id,
            
            'user_group_id' => $detail->user_group_id, // Menyimpan user_group_id
        ];
    }

    DetailGroup::insert($detailGroups);

    ActivityLog::create([
        'user_id' => Auth::id(),
        'nama_user' =>  Auth::user()->nama_user,
        'activity' => 'Membuat Subfolder',
        'description' => 'User berhasil membuat subfolder ' . $subfolder->nama_folder,
        'timestamp' => now(),
        'cabang_id' =>  Auth::user()->cabang_id,
        'role_id' =>  Auth::user()->role_id,
]);

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
    
    $idparent = $parentFolder -> id;

    $detailgrup = DetailGroup::where('folder_id', $idparent)->get();

    $roleId  = $parentFolder->role_id;

    $Cabang = Auth::user()->cabang_id;
   $Role = Auth::user()->role_id;
        
    $cabangId  = $parentFolder->cabang_id;
    
    // Buat subfolder
    $subfolder = new Folder([
        'id_folder_induk' => $parentFolder->id,
        'nama_folder' => $request->input('nama_subfolder'),
        'role_id' => $Role,

        // Sesuaikan dengan cara Anda menyimpan informasi pembuat folder
        'cabang_id' => $Cabang,
    ]);
    

    $subfolder->save();

    // Ambil semua cabang_id dan user_group_id dari parent folder
    $detailGroups = [];

    foreach ($detailgrup as $detail) {
        $detailGroups[] = [
            'folder_id' => $subfolder->id,
            'cabang_id' => $detail->cabang_id,
            'user_group_id' => $detail->user_group_id, // Menyimpan user_group_id
        ];
    }

    DetailGroup::insert($detailGroups);
    ActivityLog::create([
        'user_id' => Auth::id(),
        'nama_user' =>  Auth::user()->nama_user,
        'activity' => 'Membuat Subfolder',
        'description' => 'User berhasil membuat subfolder ' . $subfolder->nama_folder,
        'timestamp' => now(),
        'cabang_id' =>  Auth::user()->cabang_id,
        'role_id' =>  Auth::user()->role_id,
]);
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
   
   
    if (auth()->user()->cabang_id == 1){
    $usergroup = UserGroup::all();

    $nama = DetailGroup::with('UserGroup')->where('folder_id', $id)->get();
   
    $selectedGroup = $nama->pluck('user_group_id')->toArray();
    }
    else {
        $role = Auth::user()->role_id;
        $cabang = Auth::user()->cabang_id;
        $role = Auth::user()->role_id;
    
        // Menyaring data berdasarkan role pengguna
        $usergroup = UserGroup::join('detail_members', 'user_groups.id', '=', 'detail_members.user_group_id')
         ->where('detail_members.cabang_id', $cabang)
         ->orderBy('user_groups.created_at', 'desc')
         ->distinct()
         ->get(['user_groups.*']); 

    $nama = DetailGroup::with('UserGroup')->where('folder_id', $id)->get();
   
    $selectedGroup = $nama->pluck('user_group_id')->toArray();
    }

   
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
        // $usergroup = UserGroup::join('detail_members', 'user_groups.id', '=', 'detail_members.user_group_id')
        //     ->where('detail_members.cabang_id', $cabang)
        //     ->orderBy('user_groups.created_at', 'desc')
        //     ->get(['user_groups.*']);

       
        $role = Auth::user()->role_id;
        $cabang = Auth::user()->cabang_id;
        $role = Auth::user()->role_id;
    
        // Menyaring data berdasarkan role pengguna
        $usergroup = UserGroup::join('detail_members', 'user_groups.id', '=', 'detail_members.user_group_id')
         ->where('detail_members.cabang_id', $cabang)
         ->orderBy('user_groups.created_at', 'desc')
         ->distinct()
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
    $Cabang = Auth::user()->cabang_id; 
    $role = Auth::user()->role_id;

    $namafolder = $request -> nama_folder;
   


    $existingfile =  Folder::where('cabang_id', $Cabang)->where('nama_folder', $namafolder)->whereNull('id_folder_induk')-> whereNot('id', $id)->first();
    
 
    
    if($existingfile){
        
        $request->session()->flash('error', 'Folder gagal ditambahkan, nama folder sudah ada.');
        return redirect(route('superadmin.folder.index'));
    }

    if (auth()->user()->cabang_id == 1){
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
}

else {
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
}
ActivityLog::create([
    'user_id' => Auth::id(),
    'nama_user' =>  Auth::user()->nama_user,
    'activity' => 'Update Folder',
    'description' => 'User berhasil mengupdate folder ' . $folder->nama_folder,
    'timestamp' => now(),
    'cabang_id' =>  Auth::user()->cabang_id,
    'role_id' =>  Auth::user()->role_id,
]);


    $request->session()->flash('success', 'Folder berhasil diupdate.');
    return redirect(route('superadmin.folder.index'));
}


public function updatefoldergroupadmin(Request $request, $id) {
   
    $Cabang = Auth::user()->cabang_id; 
    $role = Auth::user()->role_id;

    $namafolder = $request -> nama_folder;
   

    $existingfile =  Folder::where('cabang_id', $Cabang)->where('nama_folder', $namafolder)->whereNull('id_folder_induk')-> whereNot('id', $id)->first();
    
 
    
    if($existingfile){
        
        $request->session()->flash('error', 'Folder gagal ditambahkan, nama folder sudah ada.');
        return redirect(route('admin.folder.index'));
    }
    

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
    ActivityLog::create([
        'user_id' => Auth::id(),
        'nama_user' =>  Auth::user()->nama_user,
        'activity' => 'Update Folder',
        'description' => 'User berhasil mengupdate folder ' . $folder->nama_folder,
        'timestamp' => now(),
        'cabang_id' =>  Auth::user()->cabang_id,
        'role_id' =>  Auth::user()->role_id,
    ]);
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
