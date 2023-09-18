<?php

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

Route::get('admin/cabang/index', function () {
    return view('admin.cabang.index');
})->name('admin.cabang.index');

Route::get('admin/cabang/create', function () {
    return view('admin.cabang.create');
})->name('admin.cabang.create');

Route::get('admin/user/index', function () {
    return view('admin.user.index');
})->name('admin.user.index');

Route::get('admin/user/create', function () {
    return view('admin.user.create');
})->name('admin.user.create');

Route::get('admin/usergroup/index', function () {
    return view('admin.usergroup.index');
})->name('admin.usergroup.index');

Route::get('admin/usergroup/create', function () {
    return view('admin.usergroup.create');
})->name('admin.usergroup.create');

Route::get('admin/folder/index', function () {
    return view('admin.folder.index');
})->name('admin.folder.index');

Route::get('admin/folder/create', function () {
    return view('admin.folder.create');
})->name('admin.folder.create');




Route::get('admin/file/index', function () {
    return view('admin.file.index');
})->name('admin.file.index');


Route::get('admin/file/create', function () {
    return view('admin.file.create');
})->name('admin.file.create');

Route::get('user/home', function () {
    return view('user.home');
})->name('user.home');

