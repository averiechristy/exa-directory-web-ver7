<?php

namespace App\Http\Controllers\UserController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pin;


class PinController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function pinFolder($folderId)
{
    // Tambahkan pin folder untuk user saat ini
    auth()->user()->pins()->create(['folder_id' => $folderId]);

    return redirect()->back();
}

public function unpinFolder($folderId)
{
    // Hapus pin folder untuk user saat ini
    auth()->user()->pins()->where('folder_id', $folderId)->delete();

    return redirect()->back();
}


public function pinFile($fileId)
{
    auth()->user()->pins()->create(['file_id' => $fileId]);
    return redirect()->back();
}

public function unpinFile($fileId)
{
    auth()->user()->pins()->where('file_id', $fileId)->delete();

    return redirect()->back();
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
