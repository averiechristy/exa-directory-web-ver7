<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
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
        $folders = Folder::join('detail_groups', 'folders.id', '=', 'detail_groups.folder_id')
    ->where('detail_groups.cabang_id', $Cabang)
    ->orderBy('detail_groups.created_at', 'desc')
    ->select('folders.*') // Ambil semua kolom dari tabel usergroups
    ->distinct('detail_groups.id', 'detail_groups.cabang_id')
    ->get();


    $filesByFolder = [];

    // Mengambil file untuk setiap folder
    foreach ($folders as $folder) {
        $folder_id = $folder->id;

        $files = File::with('folder')
            ->whereHas('folder', function ($query) use ($folder_id) {
                $query->where('id', $folder_id);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        // Menyimpan data file ke dalam array berdasarkan folder_id
        $filesByFolder[$folder_id] = $files;
    }


        return view("admin.file.index",[
            "files"=> $files,
            "filesByFolder" => $filesByFolder,
            "folder" => $folder
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

        $folders = Folder::join('detail_groups', 'folders.id', '=', 'detail_groups.folder_id')
        ->where('detail_groups.cabang_id', $Cabang)
        ->orderBy('detail_groups.created_at', 'desc')
        ->distinct('detail_groups.id', 'detail_groups.cabang_id')
        ->get(['folders.*']); 
    

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
            'formFileSm' => 'mimes:pdf', // Hanya menerima file PDF
        ]);

        $Cabang = Auth::user()->cabang_id; 

        $loggedInUser = auth()->user();
       
        $cabanglogged = $loggedInUser->cabang_id;

        
        $loggedInUsername = $loggedInUser->nama_user; 


        // Process the form data and store it in the database
        $folderId = $validatedData['path_folder'];
        $namaFile = $validatedData['nama_file'];
        $status = $validatedData['inlineRadioOptions'];
        $canDownload = $request->has('flexCheckIndeterminate');
        $uploadedFile = $request->file('formFileSm');
        $konten =   $request->input('konten');
        $cabang_id_user = $Cabang;

        
        if ($uploadedFile){
        if ($uploadedFile->getClientOriginalExtension() != 'pdf') {
            // File yang diunggah bukan PDF, atur pesan kesalahan dan redirect kembali
            return redirect()->back()->withErrors(['formFileSm' => 'Hanya file PDF yang diperbolehkan.']);
        }

        // Handle file upload
        $uploadedFileName = $uploadedFile->getClientOriginalName();
        $uploadedFileType = $uploadedFile->getClientOriginalExtension();
        $uploadedFileSize = $uploadedFile->getSize();

        
        // Store the file in the storage path (you may need to configure storage in your app)
        $uploadedFile->storeAs('public/files', $uploadedFileName);
    }
                 
        // Create a new File instance
        $file = new File([
            'folder_id' => $folderId,
            'nama_file' => $namaFile,
            'type' => $uploadedFileType ?? null,
'size' => $uploadedFileSize ?? null,
            'is_download' => $canDownload,
            'status' => $status,
            'file' => $uploadedFileName ?? null,
            'status_persetujuan' => 'Menunggu Persetujuan',
            'konten' =>$konten,
            'cabang_id_user' => $cabang_id_user,
            'created_by' => $loggedInUsername,
        ]);
    
        // Save the file to the database
        $file->save();

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
              'formFileSm' => 'mimes:pdf', // Hanya menerima file PDF
          ]);

          $loggedInUser = auth()->user();
          $loggedInUsername = $loggedInUser->nama_user; 
  
          $Cabang = Auth::user()->cabang_id; 
          // Process the form data and store it in the database
          $folderId = $validatedData['path_folder'];
          $namaFile = $validatedData['nama_file'];
          $status = $validatedData['inlineRadioOptions'];
          $canDownload = $request->has('flexCheckIndeterminate');
          $uploadedFile = $request->file('formFileSm');
          $folderId = $validatedData['path_folder'];
        $namaFile = $validatedData['nama_file'];
        $status = $validatedData['inlineRadioOptions'];
        $canDownload = $request->has('flexCheckIndeterminate');
        $uploadedFile = $request->file('formFileSm');
        $konten =   $request->input('konten');
        $cabang_id_user = $Cabang;
        

        
        if ($uploadedFile){
            if ($uploadedFile->getClientOriginalExtension() != 'pdf') {
                // File yang diunggah bukan PDF, atur pesan kesalahan dan redirect kembali
                return redirect()->back()->withErrors(['formFileSm' => 'Hanya file PDF yang diperbolehkan.']);
            }
    
            // Handle file upload
            $uploadedFileName = $uploadedFile->getClientOriginalName();
            $uploadedFileType = $uploadedFile->getClientOriginalExtension();
            $uploadedFileSize = $uploadedFile->getSize();
    
            
            // Store the file in the storage path (you may need to configure storage in your app)
            $uploadedFile->storeAs('public/files', $uploadedFileName);
        }
                     
            // Create a new File instance
            $file = new File([
                'folder_id' => $folderId,
                'nama_file' => $namaFile,
                'type' => $uploadedFileType ?? null,
    'size' => $uploadedFileSize ?? null,
                'is_download' => $canDownload,
                'status' => $status,
                'file' => $uploadedFileName ?? null,
                'status_persetujuan' => 'Menunggu Persetujuan',
                'konten' =>$konten,
                'created_by' => $loggedInUsername,
                'cabang_id_user' => $cabang_id_user,
            ]);
        
          
      
          // Save the file to the database
          $file->save();
  
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

        return view('superadmin.file.edit',[
            'folders'=> $folders,
            'data'=> $data
        ]);
    }


    public function fileshow(string $id)
    {
        $Cabang = Auth::user()->cabang_id; 

        $data = File::find($id);
        $folders = Folder::join('detail_groups', 'folders.id', '=', 'detail_groups.folder_id')
        ->where('detail_groups.cabang_id', $Cabang)
        ->orderBy('detail_groups.created_at', 'desc')
        ->distinct('detail_groups.id', 'detail_groups.cabang_id')
        ->get(['folders.*']); 
    
        return view('admin.file.edit',[
            'folders'=> $folders,
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
        $request->validate([
            'path_folder' => 'required',
            'nama_file' => 'required',
            'inlineRadioOptions' => 'required',
            'formFileSm' => 'nullable|mimes:pdf', // Menerima file PDF, tetapi bersifat opsional
        ]);
    
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
      
        // Proses upload file jika ada file yang diunggah
        if ($request->hasFile('formFileSm')) {
            // Hapus file lama sebelum menggantinya dengan yang baru
            Storage::disk('public')->delete($file->file);
    
            // Lakukan proses upload file dan simpan nama file yang diunggah ke dalam database
            $uploadedFile = $request->file('formFileSm');
            $uploadedFileName = $uploadedFile->getClientOriginalName();
            $uploadedFileType = $uploadedFile->getClientOriginalExtension();
            $uploadedFileSize = $uploadedFile->getSize();
    
            // Store the file in the storage path
            $uploadedFile->storeAs('public/files', $uploadedFileName);
    
            // Update data file dengan yang baru
            $file->file = $uploadedFileName;
            $file->type = $uploadedFileType;
            $file->size = $uploadedFileSize;
        }
    
        // Simpan perubahan
        $file->save();
    
        // Redirect atau response sesuai kebutuhan Anda
        $request->session()->flash('success', "File Berhasil diedit.");
    
        return redirect()->route('superadmin.file.index');
    }

    public function fileupdate(Request $request, string $id)
    {
        $request->validate([
            'path_folder' => 'required',
            'nama_file' => 'required',
            'inlineRadioOptions' => 'required',
            'formFileSm' => 'nullable|mimes:pdf', // Menerima file PDF, tetapi bersifat opsional
        ]);
    
        // Ambil data file yang akan diupdate
        $file = File::find($id);
    
        $loggedInUser = auth()->user();
        $loggedInUsername = $loggedInUser->nama_user;     
        // Update data berdasarkan input form
        $file->folder_id = $request->input('path_folder');
        $file->nama_file = $request->input('nama_file');
        $file->status = $request->input('inlineRadioOptions');
        $file->is_download = $request->has('flexCheckIndeterminate') ? 1 : 0;
        $file->konten = $request->input('konten');
        $file->status_persetujuan = 'Menunggu Persetujuan';
        $file->updated_by = $loggedInUsername;
      
    
        if ($request->hasFile('formFileSm')) {
            // Hapus file lama sebelum menggantinya dengan yang baru
            Storage::disk('public')->delete($file->file);
    
            // Lakukan proses upload file dan simpan nama file yang diunggah ke dalam database
            $uploadedFile = $request->file('formFileSm');
            $uploadedFileName = $uploadedFile->getClientOriginalName();
            $uploadedFileType = $uploadedFile->getClientOriginalExtension();
            $uploadedFileSize = $uploadedFile->getSize();
    
            // Store the file in the storage path
            $uploadedFile->storeAs('public/files', $uploadedFileName);
    
            // Update data file dengan yang baru
            $file->file = $uploadedFileName;
            $file->type = $uploadedFileType;
            $file->size = $uploadedFileSize;
        }
    
        // Simpan perubahan
        $file->save();
    
        // Redirect atau response sesuai kebutuhan Anda
        $request->session()->flash('success', "File Berhasil diedit.");
    
        return redirect()->route('admin.file.index');
    }


    public function tampilkonten($id){
        $data = File::find($id);
        return view('superadmin.file.detail',[
            'data'=> $data,
        ]);
    }

    public function tampilkontenapproval($id){
        $data = File::find($id);
        return view('approval.detail',[
            'data'=> $data,
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


