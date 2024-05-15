<?php
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CrudsController;
use App\Http\Controllers\DeleteController;
use App\Http\Controllers\GaleryController;
use App\Http\Controllers\ProfileController;

use App\Http\Controllers\CMS\LogsController;
use App\Http\Controllers\CMS\UserController;
use App\Http\Controllers\CMS\RolesController;
use App\Http\Controllers\CMS\DashboardController;
use App\Http\Controllers\CMS\RedesSociaisController;
use App\Http\Controllers\CMS\ConfiguraçõesController;

use App\Http\Controllers\Portal\PortalController;

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
require __DIR__ . '/auth.php';

// Auth
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Portal
Route::get('/', [PortalController::class, 'index'])->name('home.index');

// CMS
Route::middleware('auth')->prefix('cms')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard')->middleware(['auth', 'verified']);

    Route::get('/', fn() => redirect()->route('dashboard'));

    Route::middleware(['can:read_cruds'])->resource('/cruds', CrudsController::class);
    Route::middleware(['can:read_logs'])->resource('/logs', LogsController::class);
    Route::middleware(['can:read_redes-sociais'])->resource('/redes-sociais', RedesSociaisController::class);
    Route::middleware(['can:read_cargos'])->resource('/cargos', RolesController::class);
    Route::middleware(['can:read_usuarios'])->resource('/usuarios', UserController::class);

    Route::prefix('api')->group(function () {
        Route::get('/cruds', [CrudsController::class, 'indexAPI']);
        Route::get('/logs', [LogsController::class, 'indexAPI']);
        Route::get('/redes-sociais', [RedesSociaisController::class, 'indexAPI']);
        Route::get('/users', [UserController::class, 'indexAPI']);
        Route::get('/cargos', [RolesController::class, 'indexAPI']);
    });

    // Update API
    Route::prefix('update')->group(function () {
        Route::middleware(['can:update_cargos'])->post('/cargos', [RolesController::class, 'managePerms']);
    });

    // Galerias
    Route::prefix('galeria')->group(function () {
        Route::get('/{table}/{id}', [GaleryController::class, 'galery'])->name('galery.index');
        Route::post('/{table}/{id}', [GaleryController::class, 'store'])->name('galery.store');
    });

    // Config
    Route::get('/configuracoes', [ConfiguraçõesController::class, 'index'])->name('config.index');
    Route::put('/configuracoes/update', [ConfiguraçõesController::class, 'update'])->name('config.update');

    // Utils
    Route::delete('delete/{tabela}/{id}', [DeleteController::class, 'delete'])->name('delete');
});
