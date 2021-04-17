<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShiftKaryawanController;
use App\Http\Livewire\Frontpage;

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

Route::get("/shift_karyawan/cetak_pdf", [ShiftKaryawanController::class, 'cetakPdf']);
Route::resource('shift_karyawan', ShiftKaryawanController::class);
Route::post("shift_karyawan/datatable", [ShiftKaryawanController::class, 'datatable']);

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::group(['middleware' => [
    'auth:sanctum',
    'verified',
    'accessrole'
]], function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/pages', function () {
        return view('admin.pages');
    })->name('pages');

    Route::get('/navigation-menus', function () {
        return view('admin.navigation-menus');
    })->name('navigation-menus');

    Route::get('/users', function () {
        return view('admin.users');
    })->name('users');

    Route::get('/user-permissions', function () {
        return view('admin.user-permissions');
    })->name('user-permissions');
});

Route::get('/{urlslug}', Frontpage::class);
Route::get('/', Frontpage::class);
