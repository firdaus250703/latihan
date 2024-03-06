<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\MahasantriController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\Controller;

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

Route::get('/dashboard', function () {
    return view('master.app');
})->middleware(['auth', 'verified'])->name('dashboard');


//jalur ini diizinkan untuk user yang login 
//dan untuk user yang role nya itu user dan admin
//role itu bukan field, tapi nama alias yang ada di kernel
Route::middleware(['auth', 'role:user,admin'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/dashboard', [Controller::class, 'index'])->name('dashboard');

// routing dengan controller
Route::get('/mahasantri_petik', [MahasantriController::class, 'index'])->name('santri');
Route::get('/mahasantri/{id}', [MahasantriController::class, 'getid']);
Route::get('/mahasantri_cari', [MahasantriController::class, 'cari'])->name('search');

Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori');
Route::get('/master/create', [KategoriController::class, 'create'])->name('master.create');
Route::post('/master/store', [KategoriController::class, 'store'])->name('master.store');
Route::get('/master/show/{id}', [KategoriController::class, 'show'])->name('master.show');
Route::get('/master/destroy/{id}', [KategoriController::class, 'destroy'])->name('master.destroy');

Route::put('/master/update/{id}', [KategoriController::class, 'update'])->name('master.update');

// Route::get('/buku', [BukuController::class, 'index'])->name('buku');
// Route::get('/create', [BukuController::class, 'create'])->name('create');



// Route::get('/samsul', function () {
//     return ('Samsul');
// });
});


//role itu bukan field, tapi nama alias yang ada di kernel
//untuk jalur yang ini khusus untuk role admin
Route::middleware(['auth', 'role:admin'])->group(function () {
      Route::resource('buku', BukuController::class);
});


//ini jalur redirect kalau user role nya USER
Route::get('/user', function () {
    return "Anda User Aplikasi";
})->name('user')->middleware('auth');


//ini jalur redirect kalau user role nya ADMIN
Route::get('/admin', function () {
    return "Selamat Datang Administrator";
})->name('admin')->middleware('auth');












require __DIR__.'/auth.php';




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

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/', function () {
//     return view('master.app');
// });

// Route::get('/', function () {
//     return view('project-app.mahasantri');
// });

// Route::get('/kategori', function () {
//     return view('master.kategori');
// });

// Route::get('/dashboard', function () {
//     return view('dashboard');
// });

