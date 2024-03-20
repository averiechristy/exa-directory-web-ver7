<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use App\Models\DetailFile;
use App\Models\DetailMember;
use App\Models\File;
use App\Models\UserGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApprovalPageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   
    public function index()
    {
        $Cabang = Auth::user()->cabang_id; 

        $userid = Auth::user()->id;
        
      

        $data = File::where('user_approval', $userid)->get();

    

        
            
        $userid = Auth::user()->id;

        $usergroups = File::select('files.id', 'files.folder_id', 'files.nama_file', 'files.status_persetujuan', 'files.catatan', 'files.updated_by','files.updated_at','files.created_at' ,'files.created_by','detail_groups.user_group_id', 'user_groups.nama_group')
            ->join('folders', 'files.folder_id', '=', 'folders.id')
            ->join('detail_groups', 'folders.id', '=', 'detail_groups.folder_id')
            ->join('user_groups', 'detail_groups.user_group_id', '=', 'user_groups.id')
            ->where('files.user_approval', $userid) // Menyesuaikan kondisi where
            ->groupBy('files.id', 'files.folder_id', 'files.nama_file', 'files.status','files.status_persetujuan', 'files.catatan', 'files.updated_by','files.updated_at','files.created_at' ,'files.created_by','detail_groups.user_group_id', 'user_groups.nama_group')
            ->get();
        
        $groupedResults = [];

    

        foreach ($usergroups as $usergroup) {
           
            // Membuat kunci unik untuk setiap file berdasarkan nama_file dan status
            $key = $usergroup->nama_file . '_' . $usergroup->status_persetujuan;
        
            // Menambahkan user_group_id ke dalam array yang sesuai dengan kunci
            if (!isset($groupedResults[$key])) {
                $groupedResults[$key] = [
                    'id' => $usergroup->id,
                    'nama_file' => $usergroup->nama_file,
                    'status_persetujuan' => $usergroup->status_persetujuan,
                    'catatan' => $usergroup -> catatan,
                    'updated_by' => $usergroup->updated_by,
                    'updated_at' => $usergroup -> updated_at,
                    'created_by' => $usergroup->created_by,
                    'created_at' => $usergroup -> created_at,
                    'folder' => $usergroup->folder->getFolderPath(),
                    'usergroup_ids' => [$usergroup->user_group_id],
                    'nama_group' => [$usergroup->nama_group]
                ];
            } else {
                $groupedResults[$key]['usergroup_ids'][] = $usergroup->user_group_id;
                $groupedResults[$key]['nama_group'][] = $usergroup->nama_group;
            }

        }
        
        $groupedResults = array_values($groupedResults);
        
  
        return view("superadmin.approvalpage",[
            'data' => $data,
            'groupedResults' => $groupedResults,
        ]);
    }



    public function userindex()
    {
        $Cabang = Auth::user()->cabang_id; 

        $userid = Auth::user()->id;
        
      

        $data = File::where('user_approval', $userid)->get();

      
            
        $userid = Auth::user()->id;

        $usergroups = File::select('files.id', 'files.folder_id', 'files.nama_file', 'files.status_persetujuan', 'files.catatan', 'files.updated_by','files.updated_at','files.created_at' ,'files.created_by','detail_groups.user_group_id', 'user_groups.nama_group')
            ->join('folders', 'files.folder_id', '=', 'folders.id')
            ->join('detail_groups', 'folders.id', '=', 'detail_groups.folder_id')
            ->join('user_groups', 'detail_groups.user_group_id', '=', 'user_groups.id')
            ->where('files.user_approval', $userid) // Menyesuaikan kondisi where
            ->groupBy('files.id', 'files.folder_id', 'files.nama_file', 'files.status','files.status_persetujuan', 'files.catatan', 'files.updated_by','files.updated_at','files.created_at' ,'files.created_by','detail_groups.user_group_id', 'user_groups.nama_group')
            ->get();
        
        $groupedResults = [];

        

        foreach ($usergroups as $usergroup) {
           
            // Membuat kunci unik untuk setiap file berdasarkan nama_file dan status
            $key = $usergroup->nama_file . '_' . $usergroup->status_persetujuan;
        
            // Menambahkan user_group_id ke dalam array yang sesuai dengan kunci
            if (!isset($groupedResults[$key])) {
                $groupedResults[$key] = [
                    'id' => $usergroup->id,
                    'nama_file' => $usergroup->nama_file,
                    'status_persetujuan' => $usergroup->status_persetujuan,
                    'catatan' => $usergroup -> catatan,
                    'updated_by' => $usergroup->updated_by,
                    'updated_at' => $usergroup -> updated_at,
                    'created_by' => $usergroup->created_by,
                    'created_at' => $usergroup -> created_at,
                    'folder' => $usergroup->folder->getFolderPath(),
                    'usergroup_ids' => [$usergroup->user_group_id],
                    'nama_group' => [$usergroup->nama_group]
                ];
            } else {
                $groupedResults[$key]['usergroup_ids'][] = $usergroup->user_group_id;
                $groupedResults[$key]['nama_group'][] = $usergroup->nama_group;
            }

        }
        
        $groupedResults = array_values($groupedResults);
        
  
        return view("user.approvalpage",[
            'data' => $data,
            'groupedResults' => $groupedResults,
        ]);
    }

    public function adminindex()
    {
        $Cabang = Auth::user()->cabang_id; 

        $userid = Auth::user()->id;
        
      

        $data = File::where('user_approval', $userid)->get();

      
            
        $userid = Auth::user()->id;

        $usergroups = File::select('files.id', 'files.folder_id', 'files.nama_file', 'files.status_persetujuan', 'files.catatan', 'files.updated_by','files.updated_at','files.created_at' ,'files.created_by','detail_groups.user_group_id', 'user_groups.nama_group')
            ->join('folders', 'files.folder_id', '=', 'folders.id')
            ->join('detail_groups', 'folders.id', '=', 'detail_groups.folder_id')
            ->join('user_groups', 'detail_groups.user_group_id', '=', 'user_groups.id')
            ->where('files.user_approval', $userid) // Menyesuaikan kondisi where
            ->groupBy('files.id', 'files.folder_id', 'files.nama_file', 'files.status','files.status_persetujuan', 'files.catatan', 'files.updated_by','files.updated_at','files.created_at' ,'files.created_by','detail_groups.user_group_id', 'user_groups.nama_group')
            ->get();
        
        $groupedResults = [];

        

        foreach ($usergroups as $usergroup) {
           
            // Membuat kunci unik untuk setiap file berdasarkan nama_file dan status
            $key = $usergroup->nama_file . '_' . $usergroup->status_persetujuan;
        
            // Menambahkan user_group_id ke dalam array yang sesuai dengan kunci
            if (!isset($groupedResults[$key])) {
                $groupedResults[$key] = [
                    'id' => $usergroup->id,
                    'nama_file' => $usergroup->nama_file,
                    'status_persetujuan' => $usergroup->status_persetujuan,
                    'catatan' => $usergroup -> catatan,
                    'updated_by' => $usergroup->updated_by,
                    'updated_at' => $usergroup -> updated_at,
                    'created_by' => $usergroup->created_by,
                    'created_at' => $usergroup -> created_at,
                    'folder' => $usergroup->folder->getFolderPath(),
                    'usergroup_ids' => [$usergroup->user_group_id],
                    'nama_group' => [$usergroup->nama_group]
                ];
            } else {
                $groupedResults[$key]['usergroup_ids'][] = $usergroup->user_group_id;
                $groupedResults[$key]['nama_group'][] = $usergroup->nama_group;
            }

        }
        
        $groupedResults = array_values($groupedResults);
        
  
        return view("admin.approvalpage",[
            'data' => $data,
            'groupedResults' => $groupedResults,
        ]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function viewkonten($id){

        $data = File::find($id);

        $detailFiles = DetailFile::with('File')->where('file_id', $id)->get();
        dd($detailFiles);
     
        return view('approval.viewkonten',[
            'data'=> $data,
            'detailFiles'=> $detailFiles,
        ]);
    }
    public function detailmemberapproval($id) {

        $data = UserGroup::find($id);

        $member = DetailMember::with('User')->where('user_group_id', $id)->get();
           
        
        return view('superadmin.approvaldetailgroup', [
            'data'=> $data,
            'member'=> $member
        ]);
    }

    public function detailmemberapprovaladmin($id) {

        $data = UserGroup::find($id);

        $member = DetailMember::with('User')->where('user_group_id', $id)->get();
           
        
        return view('admin.approvaldetailgroup', [
            'data'=> $data,
            'member'=> $member
        ]);
    }

    public function detailmemberapprovaluser($id) {

        $data = UserGroup::find($id);

        $member = DetailMember::with('User')->where('user_group_id', $id)->get();
           
        
        return view('user.approvalpagedetailgroup', [
            'data'=> $data,
            'member'=> $member
        ]);
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
