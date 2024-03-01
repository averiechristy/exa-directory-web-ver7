<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use App\Models\DetailFile;
use App\Models\DetailMember;
use App\Models\File;
use App\Models\Folder;
use App\Models\Pin;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class FileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $files = File::with('folder')
        ->orderBy('created_at', 'desc')
        ->get();

        return view("superadmin.file.index",[
            "files"=> $files
        ]);
    }


    public function updatestatus(Request $request, $id){

        $file = File::find($id);
        
        $statuspersetujuan = $file-> status_persetujuan;

        $statuspersetujuanbaru = $request->status_persetujuan;

        $catatan = $request->catatan;

        $file->status_persetujuan = $request->status_persetujuan;
        $file->catatan = $request->catatan;



        $file->save();

        $request->session()->flash('success', "Perubahan Berhasil Disimpan");

        return redirect(route('approval.dashboard'));

    }


    public function fileindex()
    {
        $Cabang = Auth::user()->cabang_id;
      // Logika pertama: Menampilkan file jika folder dibuat oleh cabang admin
$user = Auth::user();
$memberDetails = DetailMember::where('user_id', $user->id)->get();

$foldersByAdmin = Folder::where('cabang_id', $Cabang)->get();

$filesByFolder = [];

foreach ($foldersByAdmin as $folder) {
    $folder_id = $folder->id;

    $files = File::with('folder')
        ->whereHas('folder', function ($query) use ($folder_id) {
            $query->where('id', $folder_id);
        })
        ->orderBy('created_at', 'desc')
        ->get();

    $filesByFolder[$folder_id] = $files;
}

// Logika kedua: Menampilkan file jika dalam folder terdapat member detail dari user yang sedang login
$foldersForMember = Folder::whereNull('id_folder_induk')
    ->whereHas('DetailGroup', function ($query) use ($memberDetails) {
        $query->whereIn('user_group_id', $memberDetails->pluck('user_group_id')->toArray());
    })
    ->orderBy('created_at', 'desc')
    ->get();

$filesByFolderForMember = [];

foreach ($foldersForMember as $folder) {
    $folder_id = $folder->id;

    $files = File::with('folder')
        ->whereHas('folder', function ($query) use ($folder_id) {
            $query->where('id', $folder_id);
        })
        ->orderBy('created_at', 'desc')
        ->get();

    $filesByFolderForMember[$folder_id] = $files;
}


// Pass the first folder to the view for each logic
$folderAdmin = $foldersByAdmin->first();
$folderMember = $foldersForMember->first();

        
    
        return view("admin.file.index", [
            "files" => $files,
            "filesByFolder" => $filesByFolder,
            "folder" => $folder,
            "filesByFolderForMember" => $filesByFolderForMember
        ]);
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $folders = Folder::all();
        return view("superadmin.file.create",[
            "folders"=> $folders,
            
        ]);
    }


    public function filecreate()
    {

        $Cabang = Auth::user()->cabang_id; 

        // $folders = Folder::join('detail_groups', 'folders.id', '=', 'detail_groups.folder_id')
        // ->where('detail_groups.cabang_id', $Cabang)
        // ->orderBy('detail_groups.created_at', 'desc')
        // ->distinct('detail_groups.id', 'detail_groups.cabang_id')
        // ->get(['folders.*']); 


     $folders = Folder::where('cabang_id', $Cabang)->get();

        return view("admin.file.create",[
            "folders"=> $folders
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'path_folder' => 'required|exists:folders,id',
            'nama_file' => 'required|string',
            'inlineRadioOptions' => 'required|in:berlaku,tidak_berlaku',
            'flexCheckIndeterminate' => 'nullable|boolean',
            'formFileSm.*' => 'max:25000|mimes:jpg,jpeg,png,gif,mp4,mov,avi,pdf,mp3,wav',
        
        ]);
    
        // Retrieve necessary user information
        $loggedInUser = auth()->user();
        $cabanglogged = $loggedInUser->cabang_id;
        $loggedInUsername = $loggedInUser->nama_user;

        $path= $request->path_folder;
        
        // Process the form data and store it in the database
        $folderId = $validatedData['path_folder'];
        $namaFile = $validatedData['nama_file'];
        $status = $validatedData['inlineRadioOptions'];
        $canDownload = $request->has('flexCheckIndeterminate');
        $konten = $request->input('konten');
        $cabang_id_user = $cabanglogged;
        $formdinamis = $request->file('formFileSm');

   
    
        // Create a new File instance and save it to the database
        $file = new File([
            'folder_id' => $folderId,
            'nama_file' => $namaFile,
            'status' => $status,
            'is_download' => $canDownload,
            'status_persetujuan' => 'Menunggu Persetujuan',
            'konten' => $konten,
            'cabang_id_user' => $cabang_id_user,
            'created_by' => $loggedInUsername,
        ]);
    
        $file->save();
        if ($request->hasFile('formFileSm')) {
        // Handle file uploads
        foreach ($request->file('formFileSm') as $uploadedFile) {
            // Handle each uploaded file
            $uploadedFileName = $uploadedFile->getClientOriginalName();
            $uploadedFileType = $uploadedFile->getClientOriginalExtension();
            $uploadedFileSize = $uploadedFile->getSize();
    
            // Store the file in the storage path
            $uploadedFile->storeAs('public/files', $uploadedFileName);
    
            // Create and save a new detail_file instance
            $detailFile = new DetailFile([
                'file_id' => $file->id,
                'file' => $uploadedFileName,
                'type' => $uploadedFileType,
                'size' => $uploadedFileSize,
            ]);
    
            $detailFile->save();
        }
    }
        // Redirect to a specific route or page after successful submission
        $request->session()->flash('success', "File Berhasil ditambah.");
    
        return redirect()->route('superadmin.file.index');
    }
    
    


    public function filestore(Request $request)
    {

        $validatedData = $request->validate([
            'path_folder' => 'required|exists:folders,id',
            'nama_file' => 'required|string',
            'inlineRadioOptions' => 'required|in:berlaku,tidak_berlaku',
            'flexCheckIndeterminate' => 'nullable|boolean',
            'formFileSm.*' => 'max:25000|mimes:jpg,jpeg,png,gif,mp4,mov,avi,pdf,mp3,wav',
                ]);
    
        // Retrieve necessary user information
        $loggedInUser = auth()->user();
        $cabanglogged = $loggedInUser->cabang_id;
        $loggedInUsername = $loggedInUser->nama_user;

    
        // Process the form data and store it in the database
         $folderId = $validatedData['path_folder'];
        $namaFile = $validatedData['nama_file'];
        $status = $validatedData['inlineRadioOptions'];
        $canDownload = $request->has('flexCheckIndeterminate');
        $konten = $request->input('konten');
        $cabang_id_user = $cabanglogged;
        $formdinamis = $request->file('formFileSm');

   
    
        // Create a new File instance and save it to the database
        $file = new File([
            'folder_id' => $folderId,
            'nama_file' => $namaFile,
            'status' => $status,
            'is_download' => $canDownload,
            'status_persetujuan' => 'Menunggu Persetujuan',
            'konten' => $konten,
            'cabang_id_user' => $cabang_id_user,
            'created_by' => $loggedInUsername,
        ]);
    
        $file->save();
        if ($request->hasFile('formFileSm')) {
        // Handle file uploads
        foreach ($request->file('formFileSm') as $uploadedFile) {
            // Handle each uploaded file
            $uploadedFileName = $uploadedFile->getClientOriginalName();
            $uploadedFileType = $uploadedFile->getClientOriginalExtension();
            $uploadedFileSize = $uploadedFile->getSize();
    
            // Store the file in the storage path
            $uploadedFile->storeAs('public/files', $uploadedFileName);
    
            // Create and save a new detail_file instance
            $detailFile = new DetailFile([
                'file_id' => $file->id,
                'file' => $uploadedFileName,
                'type' => $uploadedFileType,
                'size' => $uploadedFileSize,
            ]);
    
            $detailFile->save();
        }
    }
        // Redirect to a specific route or page after successful submission
        $request->session()->flash('success', "File Berhasil ditambah.");
    
        return redirect()->route('admin.file.index');
    }
  
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = File::find($id);
        $folders = Folder::all();

        $nama = DetailFile::with('File')->where('file_id', $id)->get();
        
      
        return view('superadmin.file.edit',[
            'folders'=> $folders,
            'data'=> $data,
            'nama' => $nama,
        ]);
    }


    public function fileshow(string $id)
    {
        $Cabang = Auth::user()->cabang_id; 

        $data = File::find($id);
     
        $folders = Folder::where('cabang_id', $Cabang)->get();

        $nama = DetailFile::with('File')->where('file_id', $id)->get();
    
        return view('admin.file.edit',[
            'folders'=> $folders,
            'data'=> $data,
            'nama' => $nama,
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
        $request->validate([
            'path_folder' => 'required|exists:folders,id',
            'nama_file' => 'required|string',
            'inlineRadioOptions' => 'required|in:berlaku,tidak_berlaku',
            'flexCheckIndeterminate' => 'nullable|boolean',
            'formFileSm.*' => 'max:25000|mimes:jpg,jpeg,png,gif,mp4,mov,avi,pdf,mp3,wav',        ]);
            
        // Ambil data file yang akan diupdate
        $file = File::find($id);
        
        $loggedInUser = auth()->user();
        $loggedInUsername = $loggedInUser->nama_user; 
        
        // Update data berdasarkan input form
        $file->folder_id = $request->input('path_folder');
        $file->nama_file = $request->input('nama_file');
        $file->status = $request->input('inlineRadioOptions');
        $file->is_download = $request->has('flexCheckIndeterminate') ? 1 : 0;
        $file->status_persetujuan = 'Menunggu Persetujuan';
        $file->konten = $request->input('konten');
        $file->updated_by = $loggedInUsername;

        $formdinamis = $request->file('formFileSm');

     
        $file->save();

        $existingfile = $request -> exisiting_file;
       
       if($existingfile != null){
        $filesToDelete = DetailFile::where('file_id', $file->id)
        ->whereNotIn('id', $existingfile)
        ->get();


        foreach ($filesToDelete as $fileToDelete) {
            Storage::delete('public/files/' . $fileToDelete->file);
            $fileToDelete->delete();
        }
    }
        
        $uploadData=[];
      
        // Proses upload file jika ada file yang diunggah
        
    
        // Simpan perubahan
     
    
        if ($request->hasFile('formFileSm')) {
            // Handle file uploads
            foreach ($request->file('formFileSm') as $uploadedFile) {
                // Handle each uploaded file
                $uploadedFileName = $uploadedFile->getClientOriginalName();
                $uploadedFileType = $uploadedFile->getClientOriginalExtension();
                $uploadedFileSize = $uploadedFile->getSize();
        
                // Store the file in the storage path
                $uploadedFile->storeAs('public/files', $uploadedFileName);
        
                // Create and save a new detail_file instance
                $uploadData = new DetailFile([
                    'file_id' => $file->id,
                    'file' => $uploadedFileName,
                    'type' => $uploadedFileType,
                    'size' => $uploadedFileSize,
                ]);

                
                $uploadData->save();
            }
        }

        
        // Redirect to a specific route or page after successful update
        $request->session()->flash('success', "File berhasil diperbarui.");
    
        return redirect()->route('superadmin.file.index');
    }

    public function fileupdate(Request $request, string $id)
    {      
        $request->validate([
            'path_folder' => 'required|exists:folders,id',
            'nama_file' => 'required|string',
            'inlineRadioOptions' => 'required|in:berlaku,tidak_berlaku',
            'flexCheckIndeterminate' => 'nullable|boolean',
            'formFileSm.*' => 'max:25000|mimes:jpg,jpeg,png,gif,mp4,mov,avi,pdf,mp3,wav',        ]);
            
        // Ambil data file yang akan diupdate
        $file = File::find($id);
        
        $loggedInUser = auth()->user();
        $loggedInUsername = $loggedInUser->nama_user; 
        
        // Update data berdasarkan input form
        $file->folder_id = $request->input('path_folder');
        $file->nama_file = $request->input('nama_file');
        $file->status = $request->input('inlineRadioOptions');
        $file->is_download = $request->has('flexCheckIndeterminate') ? 1 : 0;
        $file->status_persetujuan = 'Menunggu Persetujuan';
        $file->konten = $request->input('konten');
        $file->updated_by = $loggedInUsername;

        $formdinamis = $request->file('formFileSm');

     
        $file->save();

        $existingfile = $request -> exisiting_file;
       

        $filesToDelete = DetailFile::where('file_id', $file->id)
        ->whereNotIn('id', $existingfile)
        ->get();

        foreach ($filesToDelete as $fileToDelete) {
            Storage::delete('public/files/' . $fileToDelete->file);
            $fileToDelete->delete();
        }
        
        $uploadData=[];
      
        // Proses upload file jika ada file yang diunggah
        
    
        // Simpan perubahan
     
    
        if ($request->hasFile('formFileSm')) {
            // Handle file uploads
            foreach ($request->file('formFileSm') as $uploadedFile) {
                // Handle each uploaded file
                $uploadedFileName = $uploadedFile->getClientOriginalName();
                $uploadedFileType = $uploadedFile->getClientOriginalExtension();
                $uploadedFileSize = $uploadedFile->getSize();
        
                // Store the file in the storage path
                $uploadedFile->storeAs('public/files', $uploadedFileName);
        
                // Create and save a new detail_file instance
                $uploadData = new DetailFile([
                    'file_id' => $file->id,
                    'file' => $uploadedFileName,
                    'type' => $uploadedFileType,
                    'size' => $uploadedFileSize,
                ]);

                
                $uploadData->save();
            }
        }

        
        // Redirect to a specific route or page after successful update
        $request->session()->flash('success', "File berhasil diperbarui.");
    
        return redirect()->route('admin.file.index');
    }


    public function tampilkonten($id){
        $data = File::find($id);

        $detailFiles = DetailFile::with('File')->where('file_id', $id)->get();
     
        return view('superadmin.file.detail',[
            'data'=> $data,
            'detailFiles'=> $detailFiles,
        ]);
    }

    
    public function admintampilkonten($id){
        $data = File::find($id);

        $detailFiles = DetailFile::with('File')->where('file_id', $id)->get();
     
        return view('admin.file.detail',[
            'data'=> $data,
            'detailFiles'=> $detailFiles,
        ]);
    }

    public function tampilkontenapproval($id){
        $data = File::find($id);

        $detailFiles = DetailFile::with('File')->where('file_id', $id)->get();
      
        return view('approval.detail',[
            'data'=> $data,
            'detailFiles' => $detailFiles,
        ]);

    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        $file = File::find($id);
        if (!empty($file)) {
            // Cetak IDs yang akan dihapus
    
            File::whereIn('id', $file)->delete();
    
            // Cetak SQL yang dihasilkan
    
            Pin::whereIn('file_id', $file)->delete();
    
            // Cetak SQL yang dihasilkan
            DetailFile::whereIn('file_id', $file)->delete();
          
        }

        $request->session()->flash('error', "File Berhasil dihapus.");

        return redirect()->route('superadmin.file.index');
    }


    public function filedestroy(Request $request, $id)
    {
        $file = File::find($id);

        if (!empty($file)) {
            // Cetak IDs yang akan dihapus
    
            File::whereIn('id', $file)->delete();
    
            // Cetak SQL yang dihasilkan
    
            Pin::whereIn('file_id', $file)->delete();
    
            // Cetak SQL yang dihasilkan
    
          
        }
      

        $request->session()->flash('error', "File Berhasil dihapus.");

        return redirect()->route('admin.file.index');
    }
}


