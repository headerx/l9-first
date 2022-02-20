<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');


Route::resource('user', App\Http\Controllers\UserController::class)->except('show');

Route::group(['prefix' => 'user-forms', 'as' => 'user-forms.'], function () {
    Route::get('/edit/{user?}', \App\Http\Livewire\Forms\UserForm::class)->name('edit');
});


Route::resource('role', App\Http\Controllers\RoleController::class)->except('show');

Route::resource('permission', App\Http\Controllers\PermissionController::class)->except('show');

