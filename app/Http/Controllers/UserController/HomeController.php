<?php

namespace App\Http\Controllers\UserController;

use App\Http\Controllers\Controller;
use App\Models\DetailMember;
use App\Models\Folder;
use App\Models\File;
use App\Models\Pin;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Mendapatkan informasi user login
        $user = Auth::user();


        // Mendapatkan semua detail member yang memiliki user_id sama dengan user login
        $memberDetails = DetailMember::where('user_id', $user->id)->get();

       
        $userPins = Pin::where('user_id', auth()->user()->id)->get();

       
        // Mendapatkan semua folder dari database yang memiliki cabang_id yang sama dengan user login
        $folders = Folder::whereNull('id_folder_induk')
            ->whereHas('DetailGroup', function ($query) use ($memberDetails) {
                $query->whereIn('user_group_id', $memberDetails->pluck('user_group_id')->toArray());
            })
            ->orderBy('created_at', 'desc')
            ->get();
    
        // Mendapatkan semua file yang memiliki status "berlaku" dari database
        $files = File::where('status', 'berlaku')->get();
    
        return view("user.home", [
            "folders" => $folders,
            "files" => $files,
            "userPins" => $userPins,
            
        ]);
    }
           
    public function showFolder($folderId)
{
    $folder = Folder::with('parent_folder', 'subfolders')->findOrFail($folderId);

    return view("user.show-folder", [
        "folder" => $folder,
    ]);
}

    
public function pinFolder($folderId)
{
    $user = Auth::user();

    // Mendapatkan semua detail member yang memiliki user_id sama dengan user login
    $memberDetails = DetailMember::where('user_id', $user->id)->get();
    $folders = Folder::whereNull('id_folder_induk')
    ->whereHas('DetailGroup', function ($query) use ($memberDetails) {
        $query->whereIn('user_group_id', $memberDetails->pluck('user_group_id')->toArray());
    })
    ->orderBy('created_at', 'desc')
    ->get();

// Mendapatkan semua file yang memiliki status "berlaku" dari database
$files = File::where('status', 'berlaku')->get();
    $folder = Folder::find($folderId);

    if (!$folder) {
        // Handle folder not found
    }

    // Pin the folder for the authenticated user
    $folder->pinned_by_user_id = auth()->user()->id;
    $folder->save();

    return view("user.home", [
        "folders" => $folders,
        "files" => $files,
        
    ]);
}

public function pinFile($fileId)
{
    $user = Auth::user();

    // Mendapatkan semua detail member yang memiliki user_id sama dengan user login
    $memberDetails = DetailMember::where('user_id', $user->id)->get();
    $folders = Folder::whereNull('id_folder_induk')
    ->whereHas('DetailGroup', function ($query) use ($memberDetails) {
        $query->whereIn('user_group_id', $memberDetails->pluck('user_group_id')->toArray());
    })
    ->orderBy('created_at', 'desc')
    ->get();

// Mendapatkan semua file yang memiliki status "berlaku" dari database
$files = File::where('status', 'berlaku')->get();
    $file = File::find($fileId);

    if (!$file) {
        // Handle file not found
    }

    // Pin the file for the authenticated user
    $file->pinned_by_user_id = auth()->user()->id;
    $file->save();

    // Redirect or respond as needed

    
    return view("user.home", [
        "folders" => $folders,
        "files" => $files,
        
    ]);
}
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
