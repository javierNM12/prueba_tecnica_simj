<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('inicio');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('admin/posts', function () {
    return view('posts');
});
Route::get('admin/inicio', function () {
    return view('inicio');
});
Route::get('users/list', [App\Http\Controllers\Users::class, 'list'])->middleware('auth')->name('users.list');
Route::post('users/delete_user/{id}', [App\Http\Controllers\Users::class, 'delete_user'])->middleware('auth')->name('users.delete_user');
Route::get('users/edit', [App\Http\Controllers\Users::class, 'edit'])->middleware('auth')->name('users.edit');
Route::post('users/create_user', [App\Http\Controllers\Users::class, 'create_user'])->middleware('auth')->name('users.create_user');
Route::post('users/edit_user', [App\Http\Controllers\Users::class, 'edit_user'])->middleware('auth')->name('users.edit_user');
Route::post('users/is_email_in_use', [App\Http\Controllers\Users::class, 'is_email_in_use'])->middleware('auth')->name('users.is_email_in_use');