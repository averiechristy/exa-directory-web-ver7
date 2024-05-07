<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     */

     public function superadminindex(){

        if (auth()->user()->cabang_id == 1){
           
            $activity = ActivityLog::orderBy('created_at', 'desc')->get();

            }
            else {

                $Cabang = Auth::user()->cabang_id;

                $activity = ActivityLog::where('cabang_id', $Cabang)->orderBy('created_at', 'desc')->get();
            }

        return view('superadmin.logactivity.index',[
            'activity' => $activity,
        ]);

     }

     public function adminindex(){

       
                $Cabang = Auth::user()->cabang_id;

                $activity = ActivityLog::where('cabang_id', $Cabang)->orderBy('created_at', 'desc')->get();
            

        return view('admin.logactivity.index',[
            'activity' => $activity,
        ]);

     }

    public function index()
    {
        //
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
