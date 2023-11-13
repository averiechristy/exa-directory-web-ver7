<?php

use App\Http\Controllers\AdminController\CabangController;
use App\Http\Controllers\AdminController\DashboardController;
use App\Http\Controllers\AdminController\FileController;
use App\Http\Controllers\AdminController\FolderController;
use App\Http\Controllers\AdminController\UserController;
use App\Http\Controllers\AdminController\UserGroupController;
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
    return view('welcome');
});

Route::get('/login', function () {
    return view('login');
});

Route::get('admin/dashboard', function () {
    return view('admin.dashboard');
})->name('admin.dashboard');

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

Route::get('user/home', function () {
    return view('user.home');
})->name('user.home');

Route::get('admin/changepassword', function () {
return view('admin.changepassword');
})->name('admin.changepassowrd');

Route::get('user/editprofil', function () {
return view('user.editprofil');
})->name('user.editprofil');


Route::get('user/changepassword', function () {

    return view('user.changepassword');
})->name('user.changepassword');

Route::get('admin/dashboard',[DashboardController::class,'index'])->name('admin.dashboard');

Route::get('admin/cabang/index',[CabangController::class,'index'])->name('admin.cabang.index');
Route::get('admin/cabang/create',[CabangController::class,'create'])->name('admin.cabang.create');
Route::post('admin/cabang/simpan',[CabangController::class,'store'])->name('admin.cabang.simpan');
Route::get('/tampilcabang/{id}',[CabangController::class,'show'])->name('tampilcabang');
Route::post('/updatecabang/{id}',[CabangController::class,'update'])->name('updatecabang');
Route::delete('/deletecabang/{id}',[CabangController::class,'destroy'])->name('deletecabang');


Route::get('admin/user/index',[UserController::class,'index'])->name('admin.user.index');
Route::get('admin/user/create',[UserController::class,'create'])->name('admin.user.create');
Route::post('admin/user/simpan',[UserController::class,'store'])->name('admin.user.simpan');
Route::get('/tampiluser/{id}',[UserController::class,'show'])->name('tampiluser');
Route::post('/updateuser/{id}',[UserController::class,'update'])->name('updateuser');
Route::post('/user/{user}/reset-password', [UserController::class,'resetPassword'])->name('admin.reset-password');
Route::delete('/deleteuser{id}',[UserController::class,'destroy'])->name('deleteuser');


Route::get('admin/usergroup/index',[UserGroupController::class,'index'])->name('admin.usergroup.index');
Route::get('admin/usergroup/create',[UserGroupController::class,'create'])->name('admin.usergroup.create');
Route::get('/get-users-by-branch/{cabangId}', [UserGroupController::class, 'getUsersByBranch']);
Route::post('admin/usergroup/simpan',[UserGroupController::class,'store'])->name('admin.usergroup.simpan');
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


Route::get('admin/folder/index',[FolderController::class,'index'])->name('admin.folder.index');
Route::get('admin/folder/create',[FolderController::class,'create'])->name('admin.folder.create');
Route::post('admin/folder/simpan',[FolderController::class,'store'])->name('admin.folder.simpan');
Route::get('/detailgroup/{id}',[FolderController::class,'detailgroup'])->name('detailgroup');


Route::post('/add-folder', [FolderController::class,'addFolder'])->name('folder.add');
Route::post('/folder/rename/{id}', [FolderController::class,'rename'])->name('folder.rename');
Route::delete('/folders/{id}', [FolderController::class,'delete'])->name('folder.delete');
Route::post('/folder/create-subfolder/{id}', [FolderController::class,'createSubfolder'])->name('folder.createSubfolder');

Route::get('admin/file/index',[FileController::class,'index'])->name('admin.file.index');
Route::get('admin/file/create',[FileController::class,'create'])->name('admin.file.create');
Route::post('admin/file/simpan',[FileController::class,'store'])->name('admin.file.simpan');
Route::get('tampilfile/{id}',[FileController::class,'show'])->name('tampilfile');
Route::post('/updatefile/{id}',[FileController::class,'update'])->name('updatefile');
Route::delete('/deletefile/{id}',[FileController::class,'destroy'])->name('deletefile');
