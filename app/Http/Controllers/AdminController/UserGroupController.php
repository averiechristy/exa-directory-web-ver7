<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use App\Models\Cabang;
use App\Models\DetailMember;
use App\Models\User;
use App\Models\UserGroup;
use Auth;
use Illuminate\Http\Request;

class UserGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $usergroup = UserGroup::orderBy('created_at', 'desc') ->distinct()->get();
        return view("superadmin.usergroup.index", [
            "usergroup"=> $usergroup
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
            $cabang = Cabang::all();
            $users = User::where('role_id', '3')->get();
        
            return view("superadmin.usergroup.create",[
                "cabang"=> $cabang,
                "users"=> $users,
            ]);
    }

    
    public function usergroupindex()
    {
        $cabang = Auth::user()->cabang_id;
    
        // Menyaring data berdasarkan role pengguna
        // $usergroup = UserGroup::join('detail_members', 'user_groups.id', '=', 'detail_members.user_group_id')
        //  ->where('detail_members.cabang_id', $cabang)
        //  ->orderBy('user_groups.created_at', 'desc')
        //  ->distinct()
        //  ->get(['user_groups.*']); // Ambil semua kolom dari tabel usergroups dengan entri unik

         $usergroup = UserGroup::where('cabang_id', $cabang)->distinct()->get();

// Menggunakan distinct() untuk mengambil entri unik dari hasil query

        return view("admin.usergroup.index", [
            "usergroup" => $usergroup
        ]);
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function usergroupcreate()
    {
           
            $loggedInUser = Auth::user();

            // Fetch users with the same cabang_id as the logged-in user
            $users = User::where('cabang_id', $loggedInUser->cabang_id)
                          ->get();
        
            return view("admin.usergroup.create",[
               
                "users"=> $users,
            ]);
    }


    /**
     * Store a newly created resource in storage.
     */public function store(Request $request)
{
    $loggedInUser = auth()->user();
    $loggedInUsername = $loggedInUser->nama_user; 
    $cabangId = $loggedInUser->cabang_id;
    $usergroup = new UserGroup;
    $usergroup->nama_group = $request->nama_group;
    $usergroup->created_by = $loggedInUsername;

    $usergrouptype = $request->inlineRadioOptions;

    $usergroup ->type = $usergrouptype;
$usergroup -> cabang_id = $cabangId;

    $usergroup->save();

    $detailmember = [];

    // Check apakah opsi yang dipilih adalah 'General'
    if ($request->has('inlineRadioOptions') && $request->inlineRadioOptions == 'General') {
        // Cek apakah ada anggota yang dikecualikan
        if ($request->has('anggota')) {
            // Ambil semua user dari cabang yang dipilih
            $selectedCabangs = $request->cabang;
            $users = User::whereIn('cabang_id', $selectedCabangs)->get();

            foreach ($users as $user) {
                // Cek apakah user termasuk dalam anggota yang dikecualikan
                if (!in_array($user->id, $request->anggota)) {
                    // Tambahkan detail member untuk user yang tidak dikecualikan
                    $detailmember[] = [
                        'user_group_id' => $usergroup->id,
                        'user_id' => $user->id,
                        'cabang_id' => $user->cabang_id,
                    ];
                }
            }

        } else {
            // Jika tidak ada anggota yang dikecualikan, tambahkan semua user dari cabang yang dipilih
            foreach ($request->cabang as $cabangId) {
                $users = User::where('cabang_id', $cabangId)->get();
                foreach ($users as $user) {
                    $detailmember[] = [
                        'user_group_id' => $usergroup->id,
                        'user_id' => $user->id,
                        'cabang_id' => $user->cabang_id,
                    ];
                }
            }
        }
    } else  if ($request->has('inlineRadioOptions') && $request->inlineRadioOptions == 'Custom') {
        // Jika opsi yang dipilih adalah 'Custom', simpan anggota sesuai dengan yang dipilih
        if ($request->has('anggotacustom')) {
            foreach ($request->anggotacustom as $anggotaId) {
                // Ambil informasi cabang_id dari user_id
                $user = User::find($anggotaId);
                $cabangId = $user->cabang_id;

                $detailmember[] = [
                    'user_group_id' => $usergroup->id,
                    'user_id' => $anggotaId,
                    'cabang_id' => $cabangId,
                ];
            }
        }
    }

    DetailMember::insert($detailmember);

    $request->session()->flash('success', 'User Group berhasil ditambahkan.');
    return redirect(route('superadmin.usergroup.index'));
}



public function usergroupstore(Request $request)
{
    $usergroup = new UserGroup;
    $loggedInUser = Auth::user();
    $loggedInUsername = $loggedInUser->nama_user; 
    $cabangId = $loggedInUser->cabang_id;
    $usergroup->nama_group = $request->nama_group;
    $usergroup->created_by = $loggedInUsername;
    $usergrouptype = $request->inlineRadioOptions;

    $usergroup->type = $usergrouptype;
    $usergroup -> cabang_id = $cabangId;

    $usergroup->save();

    $detailmember = [];

    // Check apakah opsi yang dipilih adalah 'General'
    if ($request->has('inlineRadioOptions') && $request->inlineRadioOptions == 'General') {
        // Ambil semua user dari cabang yang dimiliki oleh pengguna yang login
        $users = User::where('cabang_id', $loggedInUser->cabang_id)->get();

        if ($request->has('anggota')) {
            // Ambil semua user dari cabang yang dipilih
       
            $users = User::where('cabang_id', $loggedInUser->cabang_id)->get();

            foreach ($users as $user) {
                // Cek apakah user termasuk dalam anggota yang dikecualikan
                if (!in_array($user->id, $request->anggota)) {
                    // Tambahkan detail member untuk user yang tidak dikecualikan
                    $detailmember[] = [
                        'user_group_id' => $usergroup->id,
                        'user_id' => $user->id,
                        'cabang_id' => $user->cabang_id,
                    ];
                }
            }

        } else {
            // Jika tidak ada anggota yang dikecualikan, tambahkan semua user dari cabang yang dipilih
            
                $users = User::where('cabang_id', $loggedInUser->cabang_id)->get();
                foreach ($users as $user) {
                    $detailmember[] = [
                        'user_group_id' => $usergroup->id,
                        'user_id' => $user->id,
                        'cabang_id' => $user->cabang_id,
                    ];
                }
            
        }
    } else if ($request->has('inlineRadioOptions') && $request->inlineRadioOptions == 'Custom') {
        // Jika opsi yang dipilih adalah 'Custom', simpan anggota sesuai dengan yang dipilih
        if ($request->has('anggotacustom')) {
            foreach ($request->anggotacustom as $anggotaId) {
                // Ambil informasi cabang_id dari user_id
                $user = User::find($anggotaId);
                $cabangId = $user->cabang_id;

                $detailmember[] = [
                    'user_group_id' => $usergroup->id,
                    'user_id' => $anggotaId,
                    'cabang_id' => $cabangId,
                ];
            }
        }
    }

    DetailMember::insert($detailmember);

    $request->session()->flash('success', 'User Group berhasil ditambahkan.');
    return redirect(route('admin.usergroup.index'));
}


    public function detailmember($id) {

        $data = UserGroup::find($id);

        
        $member = DetailMember::with('User')->where('user_group_id', $id)->get();
        
        return view('superadmin.usergroup.detail', [
            'data'=> $data,
            'member'=> $member
        ]);
    }

    public function usergroupdetailmember($id) {

        $data = UserGroup::find($id);

        
        $member = DetailMember::with('User')->where('user_group_id', $id)->get();
        
        return view('admin.usergroup.detail', [
            'data'=> $data,
            'member'=> $member
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = UserGroup::find($id); 
        $cabang = Cabang::all();
        $users = User::all();
        $nama = DetailMember::with('User')->where('user_group_id', $id)->get();
    
        $selectedCabangs = $nama->pluck('cabang_id')->toArray();

        $groupType = $data->type;

        // Inisialisasi variabel untuk menyimpan pengguna yang dikecualikan
        $excludedUsers = [];
    
        // Jika tipe grup adalah "Custom", ambil pengguna yang dikecualikan
        if ($groupType == 'General') {
            // Ambil daftar anggota yang dikecualikan
            $excludedUserIds = $nama->pluck('user_id')->toArray();
            // Ambil semua pengguna kecuali yang dikecualikan
            $excludedUsers = User::whereNotIn('id', $excludedUserIds);
    
            // Filter pengguna berdasarkan cabang yang dipilih
            $selectedCabangs = $nama->pluck('cabang_id')->toArray();

            $excludedUsers = User::whereNotIn('id', $excludedUserIds)
            ->whereHas('cabang', function ($query) use ($selectedCabangs) {
                $query->whereIn('id', $selectedCabangs);
            })
            ->get(); // Menambahkan metode get() untuk menjalankan query dan mendapatkan kumpulan data
                    
        }
    
        // Ambil id cabang yang dipilih
        $selectedCabangs = $nama->pluck('cabang_id')->toArray();

        
    
        return view('superadmin.usergroup.edit', [
            'data'=> $data,
            'cabang'=> $cabang,
            'users'=> $users,
            'nama'=> $nama,
            'selectedCabangs' => $selectedCabangs,
            'excludedUsers' => $excludedUsers,
        ]);
    }

    public function usergroupshow(string $id)
    {
        $data = UserGroup::find($id); 
        
        $loggedInUser = Auth::user();
        $users = User::where('cabang_id', $loggedInUser->cabang_id)
        ->get();        

        
        $nama = DetailMember::with('User')->where('user_group_id', $id)->get();


        $selectedCabangs = $nama->pluck('cabang_id')->toArray();

        $groupType = $data->type;

        // Inisialisasi variabel untuk menyimpan pengguna yang dikecualikan
        $excludedUsers = [];
    
        // Jika tipe grup adalah "Custom", ambil pengguna yang dikecualikan
        if ($groupType == 'General') {
            // Ambil daftar anggota yang dikecualikan
            $excludedUserIds = $nama->pluck('user_id')->toArray();
            // Ambil semua pengguna kecuali yang dikecualikan
            $excludedUsers = User::whereNotIn('id', $excludedUserIds);
    
            // Filter pengguna berdasarkan cabang yang dipilih
            $selectedCabangs = $nama->pluck('cabang_id')->toArray();

            $excludedUsers = User::whereNotIn('id', $excludedUserIds)
            ->whereHas('cabang', function ($query) use ($selectedCabangs) {
                $query->whereIn('id', $selectedCabangs);
            })
            ->get(); // Menambahkan metode get() untuk menjalankan query dan mendapatkan kumpulan data
                    
        }
       
        

        return view('admin.usergroup.edit', [
            'data'=> $data,
            'excludedUsers' => $excludedUsers,
            'users'=> $users,
            'nama'=> $nama
        ]);
    }
    
    
    public function getMembersByCabang($cabangId)
    {
        // Fetch members based on the selected branch (Cabang)
        $members = User::whereIn('cabang_id', $cabangId)->get();

        return response()->json(['members' => $members]);
    }

    public function getAnggotaByCabang(Request $request)
{
    $cabangIds = $request->input('cabang');
    
    // Mendapatkan anggota berdasarkan cabang yang di-check
    $anggota = User::whereIn('cabang_id', $cabangIds)->get();

    return response()->json($anggota);
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
    public function update(Request $request, $id)
    {
        // Validate the request data
     
    
        // Update UserGroup
        $usergroup = UserGroup::findOrFail($id);
        $loggedInUser = auth()->user();
        $loggedInUsername = $loggedInUser->nama_user;
    
        $usergroup->nama_group = $request->nama_group;
        $usergroup->updated_by = $loggedInUsername;

        $usergrouptype = $usergroup->type;

      
       
        
        $usergroup->save();
    
        // Update or create DetailMember records
        $detailmember = [];
    
        if ( $usergrouptype == 'General') {
            foreach ($request->cabang as $cabangId) {
                $users = User::where('cabang_id', $cabangId)->get();
                foreach ($users as $user) {
                    if (!in_array($user->id, $request->anggota)) {
                        $detailmember[] = [
                            'user_group_id' => $usergroup->id,
                            'user_id' => $user->id,
                            'cabang_id' => $user->cabang_id,
                        ];
                    }
                }
            }
        } elseif ( $usergrouptype == 'Custom') {
            foreach ($request->anggotacustom as $anggotaId) {
                $user = User::find($anggotaId);
                $cabangId = $user->cabang_id;
    
                $detailmember[] = [
                    'user_group_id' => $usergroup->id,
                    'user_id' => $anggotaId,
                    'cabang_id' => $cabangId,
                ];
            }
        }
    
        // Delete existing DetailMember records for the user group
        DetailMember::where('user_group_id', $usergroup->id)->delete();
    
        // Insert updated DetailMember records
        DetailMember::insert($detailmember);
    
        // Flash success message and redirect
        $request->session()->flash('success', 'User Group berhasil diupdate.');
        return redirect()->route('superadmin.usergroup.index');
    }
       
        public function usergroupupdate(Request $request, string $id)
        {
            $usergroup = UserGroup::findOrFail($id);
            $loggedInUser = auth()->user();
            $loggedInUsername = $loggedInUser->nama_user;
        
            $usergroup->nama_group = $request->nama_group;
            $usergroup->updated_by = $loggedInUsername;
    
            $usergrouptype = $usergroup->type;
               
            $usergroup->save();
        
            // Update or create DetailMember records
            $detailmember = [];
        
            if ( $usergrouptype == 'General') {
                foreach ($request->cabang as $cabangId) {
                    $users = User::where('cabang_id', $cabangId)->get();
                    foreach ($users as $user) {
                        if (!in_array($user->id, $request->anggota)) {
                            $detailmember[] = [
                                'user_group_id' => $usergroup->id,
                                'user_id' => $user->id,
                                'cabang_id' => $user->cabang_id,
                            ];
                        }
                    }
                }
            } elseif ( $usergrouptype == 'Custom') {
                foreach ($request->anggotacustom as $anggotaId) {
                    $user = User::find($anggotaId);
                    $cabangId = $user->cabang_id;
        
                    $detailmember[] = [
                        'user_group_id' => $usergroup->id,
                        'user_id' => $anggotaId,
                        'cabang_id' => $cabangId,
                    ];
                }
            }
        
            // Delete existing DetailMember records for the user group
            DetailMember::where('user_group_id', $usergroup->id)->delete();
        
            // Insert updated DetailMember records
            DetailMember::insert($detailmember);
        
                $request->session()->flash('success', 'User Group berhasil diupdate.');
                return redirect(route('admin.usergroup.index'));
            
        }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $id)
    {
        // Temukan UserGroup yang akan dihapus
        $usergroup = UserGroup::find($id);
    
        // Periksa jika UserGroup ditemukan
        if ($usergroup) {
            // Temukan DetailMember yang memiliki user_group_id yang sama dengan UserGroup yang akan dihapus
            $detailMembers = DetailMember::where('user_group_id', $usergroup->id)->get();
    
            // Hapus semua DetailMember yang ditemukan
            foreach ($detailMembers as $detailMember) {
                $detailMember->delete();
            }
    
            // Hapus UserGroup setelah menghapus DetailMember
            $usergroup->delete();
    
            // Set flash message
            $request->session()->flash('error', "User Group Berhasil dihapus.");
        } else {
            // Jika UserGroup tidak ditemukan, set flash message sesuai kebutuhan
            $request->session()->flash('error', "User Group tidak ditemukan.");
        }
    
        // Redirect ke halaman index
        return redirect(route('superadmin.usergroup.index'));
    }
        
    public function usergroupdestroy(Request $request, $id)
    {
    $usergroup = UserGroup::find($id);
    if ($usergroup) {
        // Temukan DetailMember yang memiliki user_group_id yang sama dengan UserGroup yang akan dihapus
        $detailMembers = DetailMember::where('user_group_id', $usergroup->id)->get();

        // Hapus semua DetailMember yang ditemukan
        foreach ($detailMembers as $detailMember) {
            $detailMember->delete();
        }

        // Hapus UserGroup setelah menghapus DetailMember
        $usergroup->delete();

        // Set flash message
        $request->session()->flash('error', "User Group Berhasil dihapus.");
    } else {
        // Jika UserGroup tidak ditemukan, set flash message sesuai kebutuhan
        $request->session()->flash('error', "User Group tidak ditemukan.");
    }

    $request->session()->flash('error', "User Group Berhasil dihapus.");

    return redirect(route('admin.usergroup.index'));
}

}
