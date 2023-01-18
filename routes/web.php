<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Route::get('/', [App\Http\Controllers\FrontendController::class, 'index']);
Route::get('/start_order', [App\Http\Controllers\FrontendController::class, 'start_order']);
Route::get('/order/{id_pesanan}', [App\Http\Controllers\FrontendController::class, 'order']);
Route::get('/select_menu', [App\Http\Controllers\FrontendController::class, 'select_menu']);
Route::post('/add_pesanan', [App\Http\Controllers\FrontendController::class, 'add_pesanan']);
Route::get('/remove_pesanan', [App\Http\Controllers\FrontendController::class, 'remove_pesanan']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('admin')->middleware(['auth','admin-access'])->group(function(){
    Route::get('/',[App\Http\Controllers\AdminController::class,'index']);
    // ==== USER ====
    Route::get('/user',[App\Http\Controllers\UserController::class,'index']);
    Route::get('/user_tambah',[App\Http\Controllers\UserController::class,'tambah']);
    Route::post('/user_tambah_data',[App\Http\Controllers\UserController::class,'tambah_data']);
    Route::get('/user_edit/{id}',[App\Http\Controllers\UserController::class,'edit']);
    Route::post('/user_edit_data/{id}',[App\Http\Controllers\UserController::class,'edit_data']);
    Route::get('/user_delete/{id}',[App\Http\Controllers\UserController::class,'delete']);
    // ==== USER ====

    // ==== MASAKAN ====
    Route::get('/masakan',[App\Http\Controllers\MasakanController::class,'index']);
    Route::get('/masakan_tambah',[App\Http\Controllers\MasakanController::class,'tambah']);
    Route::post('/masakan_tambah_data',[App\Http\Controllers\MasakanController::class,'tambah_data']);
    Route::get('/masakan_delete/{id}',[App\Http\Controllers\MasakanController::class,'delete']);
    Route::get('/masakan_edit/{id_masakan}',[App\Http\Controllers\MasakanController::class,'edit']);
    Route::post('/masakan_edit_data/{id_masakan}',[App\Http\Controllers\MasakanController::class,'edit_data']);
    Route::post('/persedian_masakan/{id_masakan}',[App\Http\Controllers\MasakanController::class,'persediaan']);
    // ==== MASAKAN ====

    // ==== MEJA ====
    Route::get('/meja',[App\Http\Controllers\MejaController::class,'index']);
    Route::get('/meja_tambah',[App\Http\Controllers\MejaController::class,'tambah']);
    Route::get('/meja_delete/{no_meja}',[App\Http\Controllers\MejaController::class,'delete']);
    Route::post('/status_meja/{no_meja}',[App\Http\Controllers\MejaController::class,'status_meja']);
    // ==== MEJA ====
});
