<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use App\Models\UserRead;
use Auth;
use Illuminate\Http\Request;
use Dompdf\Dompdf;
use Dompdf\Options;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (auth()->user()->cabang_id == 1) {
        $dataread = UserRead::all();
        }
        else {
        $Cabang = Auth::user()->cabang_id;

        $dataread = UserRead::select('user_reads.*')
        ->join('users', 'users.id', '=', 'user_reads.user_id')
        ->where('users.cabang_id', $Cabang)
        ->get();
        }

        return view("superadmin.dashboard",[
            'dataread' => $dataread,
        ]);

    }

    public function adminindex()
    {
    
        $Cabang = Auth::user()->cabang_id;
        $dataread = UserRead::select('user_reads.*')
        ->join('users', 'users.id', '=', 'user_reads.user_id')
        ->where('users.cabang_id', $Cabang)
        ->get();

    
      
        return view("admin.dashboard",[
            'dataread' => $dataread,
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
