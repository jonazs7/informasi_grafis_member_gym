<?php

use App\Http\Controllers\MemberController;
use App\Http\Controllers\TrainerController;
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

// Route::get('/test', function () {
//     return view('test');
// });


// Autentifikasi
Auth::routes();
Route::get('/', function () {
    return view('auth.login');
});
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Member Gym
Route::middleware(['member'])->group(function(){
    Route::get('/beranda', [MemberController::class, 'beranda'])->name('beranda');
    Route::get('/jadwal', [MemberController::class, 'jadwal'])->name('jadwal');
    Route::get('/biodata', [MemberController::class, 'edit_biodata'])->name('edit_biodata');
    Route::post('/biodata/update', [MemberController::class, 'update_biodata'])->name('update_biodata');
    Route::post('/saveGoal', [MemberController::class, 'save_goal'])->name('saveGoal');
  
});

// Trainer Gym
Route::middleware(['trainer'])->group(function(){
    Route::get('/berandaTrainer', [TrainerController::class, 'beranda'])->name('beranda');
    Route::get('/jadwalTrainer', [TrainerController::class, 'jadwal'])->name('jadwal');
    Route::get('/hasilCapaian', [TrainerController::class, 'hasil_capaian'])->name('hasilCapaian');
    Route::get('/detailInfo', [TrainerController::class, 'detail_info'])->name('detailInfo');
    Route::get('/anggotaGym', [TrainerController::class, 'anggota_gym'])->name('anggotaGym');
    Route::post('/anggotaGym', [TrainerController::class, 'save_anggota_gym'])->name('save_anggotaGym');
    Route::delete('/anggotaGym/{kode}', [TrainerController::class, 'delete_anggota_gym'])->name('delete_anggota_gym');
    Route::get('/showKegiatan/{id}', [TrainerController::class, 'show_kegiatan'])->name('showKegiatan');
    Route::get('/profileAnggota/{id}', [TrainerController::class, 'show_profile_anggota'])->name('show_profile_anggota');
    Route::post('/saveKegiatan', [TrainerController::class, 'save_kegiatan'])->name('save_kegiatan');
    Route::delete('/deleteKegiatan/{kode_jadwal}', [TrainerController::class, 'delete_kegiatan'])->name('deleteKegiatan');
    Route::get('editKegiatan/{kode_jadwal}', [TrainerController::class, 'edit_kegiatan'])->name('editKegiatan');
    Route::post('/updateKegiatan/{kode_jadwal}', [TrainerController::class, 'update_kegiatan'])->name('updateKegiatan');
    Route::get('/createDataFisik/{kode_pengguna}', [TrainerController::class, 'create_data_fisik'])->name('createDataFisik');
    Route::post('/saveDataFisik', [TrainerController::class, 'save_data_fisik'])->name('saveDataFisik');


});


