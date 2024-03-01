<?php

use App\Http\Controllers\AdminController\ApprovalController;
use App\Http\Controllers\AdminController\CabangController;
use App\Http\Controllers\AdminController\DashboardController;
use App\Http\Controllers\AdminController\FileController;
use App\Http\Controllers\AdminController\FolderController;
use App\Http\Controllers\AdminController\PasswordController;
use App\Http\Controllers\AdminController\UserController;
use App\Http\Controllers\AdminController\UserGroupController;
use App\Http\Controllers\ApprovalController\ApprovalDashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController\HomeController;
use App\Http\Controllers\UserController\KontenReadController;
use App\Http\Controllers\UserController\PinController;
use App\Http\Controllers\UserController\ProfileController;
use App\Http\Controllers\UserController\UserPasswordController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

// Route::get('/login', function () {
//     return view('login');
// });

Route::get('superadmin/dashboard', function () {
    return view('superadmin.dashboard');
})->name('superadmin.dashboard');


Route::get('admin/dashboard', function () {
    return view('admin.dashboard');
})->name('admin.dashboard');



// Route::get('approval/dashboard', function () {
//     return view('approval.dashboard');
// })->name('approval.dashboard');

// Route::get('admin/cabang/index', function () {
//     return view('admin.cabang.index');
// })->name('admin.cabang.index');

// Route::get('admin/cabang/create', function () {
//     return view('admin.cabang.create');
// })->name('admin.cabang.create');

// Route::get('admin/user/index', function () {
//     return view('admin.user.index');
// })->name('admin.user.index');

// Route::get('admin/user/create', function () {
//     return view('admin.user.create');
// })->name('admin.user.create');

// Route::get('admin/usergroup/index', function () {
//     return view('admin.usergroup.index');
// })->name('admin.usergroup.index');

// Route::get('admin/usergroup/create', function () {
//     return view('admin.usergroup.create');
// })->name('admin.usergroup.create');

// Route::get('admin/folder/index', function () {
//     return view('admin.folder.index');
// })->name('admin.folder.index');

// Route::get('admin/folder/create', function () {
//     return view('admin.folder.create');
// })->name('admin.folder.create');

// Route::get('admin/file/index', function () {
//     return view('admin.file.index');
// })->name('admin.file.index');


// Route::get('admin/file/create', function () {
//     return view('admin.file.create');
// })->name('admin.file.create');

// Route::get('user/home', function () {
//     return view('user.home');
// })->name('user.home');

// Route::get('admin/changepassword', function () {
// return view('admin.changepassword');
// })->name('admin.changepassowrd');

// Route::get('user/editprofil', function () {
// return view('user.editprofil');
// })->name('user.editprofil');


// Route::get('user/changepassword', function () {
//     return view('user.changepassword');
// })->name('user.changepassword');


// LOGIN ROUTE
Route::get('/login',[AuthController::class,'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class,'login']);
Route::post('/logout', [AuthController::class,'logout'])->name('logout');

// SUPERADMIN ROUTE

Route::middleware('auth')->middleware('ensureUserRole:SUPER ADMIN')->group(function () {


Route::get('superadmin/dashboard',[DashboardController::class,'index'])->name('superadmin.dashboard');

Route::get('superadmin/cabang/index',[CabangController::class,'index'])->name('superadmin.cabang.index');
Route::get('superadmin/cabang/create',[CabangController::class,'create'])->name('superadmin.cabang.create');
Route::post('superadmin/cabang/simpan',[CabangController::class,'store'])->name('superadmin.cabang.simpan');
Route::get('/tampilcabang/{id}',[CabangController::class,'show'])->name('tampilcabang');
Route::post('/updatecabang/{id}',[CabangController::class,'update'])->name('updatecabang');
Route::delete('/deletecabang/{id}',[CabangController::class,'destroy'])->name('deletecabang');


Route::get('superadmin/user/index',[UserController::class,'index'])->name('superadmin.user.index');
Route::get('superadmin/user/create',[UserController::class,'create'])->name('superadmin.user.create');
Route::post('superadmin/user/simpan',[UserController::class,'store'])->name('superadmin.user.simpan');
Route::get('/tampiluser/{id}',[UserController::class,'show'])->name('tampiluser');
Route::post('/updateuser/{id}',[UserController::class,'update'])->name('updateuser');
Route::post('/user/{user}/reset-password', [UserController::class,'resetPassword'])->name('superadmin.reset-password');
Route::delete('/deleteuser{id}',[UserController::class,'destroy'])->name('deleteuser');


Route::get('superadmin/usergroup/index',[UserGroupController::class,'index'])->name('superadmin.usergroup.index');
Route::get('superadmin/usergroup/create',[UserGroupController::class,'create'])->name('superadmin.usergroup.create');
Route::get('/get-users-by-branch/{cabangId}', [UserGroupController::class, 'getUsersByBranch']);
Route::post('superadmin/usergroup/simpan',[UserGroupController::class,'store'])->name('superadmin.usergroup.simpan');
Route::get('/detailmember/{id}',[UserGroupController::class,'detailmember'])->name('detailmember');
Route::get('tampilusergroup/{id}',[UserGroupController::class,'show'])->name('tampilusergroup');
Route::delete('/deleteusergroup/{id}',[UserGroupController::class,'destroy'])->name('deleteusergroup');
Route::post('/updateusergroup/{id}',[UserGroupController::class,'update'])->name('updateusergroup');

Route::get('getMember/{id}', function ($id) {
    $member = App\Models\User::where('cabang_id',$id)
    ->where('role_id', 3)
    ->get();
    return response()->json($member);
});


Route::get('superadmin/folder/index',[FolderController::class,'index'])->name('superadmin.folder.index');
Route::get('superadmin/folder/create',[FolderController::class,'create'])->name('superadmin.folder.create');
Route::post('superadmin/folder/simpan',[FolderController::class,'store'])->name('superadmin.folder.simpan');
Route::get('/detailgroup/{id}',[FolderController::class,'detailgroup'])->name('detailgroup');


Route::post('/add-folder', [FolderController::class,'addFolder'])->name('folder.add');
Route::post('/folder/rename/{id}', [FolderController::class,'rename'])->name('folder.rename');
Route::delete('/folders/{id}', [FolderController::class,'delete'])->name('folder.delete');
Route::post('/folder/create-subfolder/{id}', [FolderController::class,'createSubfolder'])->name('folder.createSubfolder');
Route::get('/tampilfoldergroup/{id}',[FolderController::class,'tampilfoldergroup'])->name('tampilfoldergroup');
Route::post('/updatefoldergroup/{id}',[FolderController::class,'updatefoldergroup'])->name('updatefoldergroup');


Route::get('superadmin/file/index',[FileController::class,'index'])->name('superadmin.file.index');
Route::get('superadmin/file/create',[FileController::class,'create'])->name('superadmin.file.create');
Route::post('superadmin/file/simpan',[FileController::class,'store'])->name('superadmin.file.simpan');
Route::get('tampilfile/{id}',[FileController::class,'show'])->name('tampilfile');
Route::post('/updatefile/{id}',[FileController::class,'update'])->name('updatefile');
Route::delete('/deletefile/{id}',[FileController::class,'destroy'])->name('deletefile');


Route::get('/get-members/{cabangId}', [UserGroupController::class,'getMembersByCabang'])->name('get.members.by.cabang');
Route::post('/superadmin/usergroup/getAnggotaByCabang', [UserGroupController::class,'getAnggotaByCabang'])->name('superadmin.usergroup.getAnggotaByCabang');


Route::get('superadmin/file/index',[FileController::class,'index'])->name('superadmin.file.index');
Route::get('superadmin/changepassword', [PasswordController::class,'showChangePasswordFormSuperAdmin'])->name('superadmin.password');
Route::post('superadmin/changepassword', [PasswordController::class,'superadminchangePassword'])->name('superadmin-change-password');


Route::get('/tampilkonten/{id}',[FileController::class,'tampilkonten'])->name('tampilkonten');

Route::get('/get-group-members/{groupId}', [FolderController::class, 'getGroupMembers'])->name('get_group_members');

Route::get('/group/{id}/members', [FolderController::class,'getGroupMembers'])->name('group.members');

Route::get('/group/{id}/membersedit', [FolderController::class,'getGroupMembersedit'])->name('group.membersedit');


Route::get('/tampilgrup/{id}',[FolderController::class,'tampilgrup'])->name('tampilgrup');


});

Route::middleware('auth')->middleware('ensureUserRole:ADMIN')->group(function () {

//ADMIN ROUTE
Route::get('admin/user/index',[UserController::class,'userindex'])->name('admin.user.index');
Route::get('admin/user/create',[UserController::class,'usercreate'])->name('admin.user.create');
Route::post('admin/user/simpan',[UserController::class,'userstore'])->name('admin.user.simpan');
Route::get('/admintampiluser/{id}',[UserController::class,'usershow'])->name('admintampiluser');
Route::post('/adminupdateuser/{id}',[UserController::class,'userupdate'])->name('adminupdateuser');
Route::post('/user/{user}/adminreset-password', [UserController::class,'userresetPassword'])->name('admin.reset-password');
Route::delete('/admindeleteuser{id}',[UserController::class,'userdestroy'])->name('admindeleteuser');




Route::get('admin/usergroup/index',[UserGroupController::class,'usergroupindex'])->name('admin.usergroup.index');
Route::get('admin/usergroup/create',[UserGroupController::class,'usergroupcreate'])->name('admin.usergroup.create');
Route::post('admin/usergroup/simpan',[UserGroupController::class,'usergroupstore'])->name('admin.usergroup.simpan');
Route::get('/admindetailmember/{id}',[UserGroupController::class,'usergroupdetailmember'])->name('admindetailmember');
Route::get('admintampilusergroup/{id}',[UserGroupController::class,'usergroupshow'])->name('admintampilusergroup');
Route::post('/adminupdateusergroup/{id}',[UserGroupController::class,'usergroupupdate'])->name('adminupdateusergroup');
Route::delete('/admindeleteusergroup/{id}',[UserGroupController::class,'usergroupdestroy'])->name('admindeleteusergroup');


Route::get('admin/folder/index',[FolderController::class,'folderindex'])->name('admin.folder.index');
Route::get('admin/folder/create',[FolderController::class,'foldercreate'])->name('admin.folder.create');
Route::post('admin/folder/simpan',[FolderController::class,'folderstore'])->name('admin.folder.simpan');
Route::post('/folder/create-subfolder-admin/{id}', [FolderController::class,'createSubfolderadmin'])->name('folder.createSubfolderadmin');
Route::post('/folder/renameadmin/{id}', [FolderController::class,'renameadmin'])->name('folder.renameadmin');
Route::delete('/foldersadmin/{id}', [FolderController::class,'deleteadmin'])->name('folder.deleteadmin');
Route::post('/updatefoldergroupadmin/{id}',[FolderController::class,'updatefoldergroupadmin'])->name('updatefoldergroupadmin');
Route::get('/tampilfoldergroupadmin/{id}',[FolderController::class,'tampilfoldergroupadmin'])->name('tampilfoldergroupadmin');
Route::post('/updatefoldergroupadmin/{id}',[FolderController::class,'updatefoldergroupadmin'])->name('updatefoldergroupadmin');


Route::get('admin/file/index',[FileController::class,'fileindex'])->name('admin.file.index');
Route::get('admin/file/create',[FileController::class,'filecreate'])->name('admin.file.create');
Route::post('admin/file/simpan',[FileController::class,'filestore'])->name('admin.file.simpan');
Route::get('admintampilfile/{id}',[FileController::class,'fileshow'])->name('admintampilfile');
Route::post('/adminupdatefile/{id}',[FileController::class,'fileupdate'])->name('adminupdatefile');
Route::delete('/admindeletefile/{id}',[FileController::class,'filedestroy'])->name('admindeletefile');

Route::get('admin/changepassword', [PasswordController::class,'showChangePasswordFormAdmin'])->name('admin.password');
Route::post('admin/changepassword', [PasswordController::class,'adminchangePassword'])->name('admin-change-password');

Route::get('/admintampilkonten/{id}',[FileController::class,'admintampilkonten'])->name('admintampilkonten');

Route::get('/group/{id}/membersadmin', [FolderController::class,'getGroupMembersadmin'])->name('group.membersadmin');


Route::get('/tampilgrupadmin/{id}',[FolderController::class,'tampilgrupadmin'])->name('tampilgrupadmin');

});

Route::middleware('auth')->middleware('ensureUserRole:USER')->group(function () {
// USER ROUTE
Route::get('user/home',[HomeController::class,'index'])->name('user.home');
Route::get('/folder/{folderId}', [HomeController::class,'showFolder'])->name('show-folder');


Route::post('/pin-folder/{folderId}', [PinController::class, 'pinFolder'])->name('pin-folder');

// Route untuk unpin folder
Route::post('/unpin-folder/{folderId}', [PinController::class, 'unpinFolder'])->name('unpin-folder');


Route::post('/pin-file/{fileId}', [PinController::class, 'pinFile'])->name('pin-file');
Route::post('/unpin-file/{fileId}', [PinController::class, 'unpinFile'])->name('unpin-file');


Route::get('user/changepassword', [UserPasswordController::class,'showChangePasswordFormUser'])->name('user.password');
Route::post('user/changepassword', [UserPasswordController::class,'userchangePassword'])->name('user-change-password');


Route::get('/profile/edit', [ProfileController::class,'editProfileForm'])->name('edit-profile');

Route::get('user/kontenread/{id}',[KontenReadController::class,'index'])->name('user.kontenread');


});

// APPROVAl ROUTE

Route::middleware('auth')->middleware('ensureUserRole:APPROVAL')->group(function () {

    Route::get('approval/dashboard',[ApprovalDashboardController::class,'index'])->name('approval.dashboard');
    Route::post('/updatestatus/{id}',[FileController::class,'updatestatus'])->name('updatestatus');
    Route::get('/tampilkontenapproval/{id}',[FileController::class,'tampilkontenapproval'])->name('tampilkontenapproval');

    Route::get('approval/viewkonten',[ApprovalDashboardController::class,'viewkonten'])->name('approval.viewkonten');
    Route::get('/detailmemberapproval/{id}',[ApprovalDashboardController::class,'detailmemberapproval'])->name('detailmemberapproval');

});