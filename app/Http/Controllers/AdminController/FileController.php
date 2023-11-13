<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use App\Models\File;
use App\Models\Folder;
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
        return view("admin.file.index",[
            "files"=> $files
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $folders = Folder::all();
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
            'formFileSm' => 'required|mimes:pdf', // Hanya menerima file PDF
        ]);

        // Process the form data and store it in the database
        $folderId = $validatedData['path_folder'];
        $namaFile = $validatedData['nama_file'];
        $status = $validatedData['inlineRadioOptions'];
        $canDownload = $request->has('flexCheckIndeterminate');
        $uploadedFile = $request->file('formFileSm');

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
                     
        // Create a new File instance
        $file = new File([
            'folder_id' => $folderId,
            'nama_file' => $namaFile,
            'type' => $uploadedFileType,
            'size' => $uploadedFileSize,
            'is_download' => $canDownload,
            'status' => $status,
            'file' => $uploadedFileName,
            // Add 'created_by' and 'updated_by' if needed
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
    
        // Update data berdasarkan input form
        $file->folder_id = $request->input('path_folder');
        $file->nama_file = $request->input('nama_file');
        $file->status = $request->input('inlineRadioOptions');
        $file->is_download = $request->has('flexCheckIndeterminate') ? 1 : 0;
    
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
    
        return redirect()->route('admin.file.index');
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        $file = File::find($id);
        $file->delete();

        $request->session()->flash('error', "File Berhasil dihapus.");

        return redirect()->route('admin.file.index');
    }
}
