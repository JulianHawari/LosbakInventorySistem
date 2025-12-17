<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BahanBakuController;
use App\Http\Controllers\ProduksiController;
use App\Http\Controllers\TemplateController;

/*
|--------------------------------------------------------------------------
| ROOT → LANGSUNG LOGIN
|--------------------------------------------------------------------------
*/
Route::redirect('/', '/login');

/*
|--------------------------------------------------------------------------
| AUTH / DASHBOARD (BREEZE)
|--------------------------------------------------------------------------
| Breeze default redirect ke route('dashboard')
| Kita arahkan ke admin dashboard
*/
Route::middleware('auth')->get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->name('dashboard');

/*
|--------------------------------------------------------------------------
| PROFILE
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| ADMIN AREA
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

    /*
    | DASHBOARD
    */
    Route::get('/', [DashboardController::class, 'index'])
        ->name('dashboard');

    /*
    | BAHAN BAKU
    */
    Route::get('bahan', [BahanBakuController::class, 'index'])
        ->name('bahan.index');

    Route::get('bahan/create', [BahanBakuController::class, 'create'])
        ->name('bahan.create');

    Route::post('bahan', [BahanBakuController::class, 'store'])
        ->name('bahan.store');

    Route::get('bahan/{bahan}/edit', [BahanBakuController::class, 'edit'])
        ->name('bahan.edit');

    Route::put('bahan/{bahan}', [BahanBakuController::class, 'update'])
        ->name('bahan.update');

    Route::delete('bahan/{bahan}', [BahanBakuController::class, 'destroy'])
        ->name('bahan.destroy');

    // RESTOCK
    Route::get('bahan/{bahan}/restock', [BahanBakuController::class, 'restockForm'])
        ->name('bahan.restockForm');

    Route::post('bahan/{bahan}/restock', [BahanBakuController::class, 'restock'])
        ->name('bahan.restock');

    // LOG STOK
    Route::get('bahan/log-stok', [BahanBakuController::class, 'logStok'])
        ->name('bahan.logstok');

    Route::delete('bahan/log-stok/clear', [BahanBakuController::class, 'clearLogStok'])
        ->name('bahan.logstok.clear');

    /*
    | TEMPLATE
    */
    Route::resource('template', TemplateController::class);

    /*
    | PRODUKSI (SUB MENU)
    */
    Route::get('produksi', [ProduksiController::class, 'index'])
        ->name('produksi.index');

    Route::get('produksi/selesai', [ProduksiController::class, 'selesai'])
        ->name('produksi.selesai');

    Route::get('produksi/create', [ProduksiController::class, 'create'])
        ->name('produksi.create');

    Route::post('produksi', [ProduksiController::class, 'store'])
        ->name('produksi.store');

    Route::get('produksi/{produksi}', [ProduksiController::class, 'show'])
        ->name('produksi.show');

    Route::get('produksi/{produksi}/edit', [ProduksiController::class, 'edit'])
        ->name('produksi.edit');

    Route::put('produksi/{produksi}', [ProduksiController::class, 'update'])
        ->name('produksi.update');

    Route::delete('produksi/{produksi}', [ProduksiController::class, 'destroy'])
        ->name('produksi.destroy');

    Route::post('produksi/{produksi}/toggle-status', [ProduksiController::class,'toggleStatus'])
        ->name('produksi.toggleStatus');

Route::get('/produksi/{id}/spk', [ProduksiController::class, 'spk'])
    ->name('produksi.spk');

Route::get('/admin/produksi/{produksi}', [ProduksiController::class, 'show'])
    ->name('admin.produksi.show');


});

require __DIR__.'/auth.php';
