<?php

use Illuminate\Support\Facades\Route;

// Controladores principales
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PosController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\AlertaController;
use App\Http\Controllers\PerfilController;

// Auth
use App\Http\Controllers\Auth\LoginController;

// Inventario
use App\Http\Controllers\Inventario\ProductoController;
use App\Http\Controllers\Inventario\CategoriaController;
use App\Http\Controllers\Inventario\LoteController;

// Ventas
use App\Http\Controllers\Ventas\VentaController;

// Compras
use App\Http\Controllers\Compras\CompraController;
use App\Http\Controllers\Compras\ProveedorController;

// Personas
use App\Http\Controllers\Personas\UsuarioController;

// Recetas
use App\Http\Controllers\Recetas\RecetaController;

// ==================== AUTENTICACIÓN ====================
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/', function () {
    return redirect()->route('dashboard');
});

// ==================== RUTAS PROTEGIDAS ====================
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/home', [DashboardController::class, 'index'])->name('dashboard');

    // ==================== VENTAS ====================
    Route::prefix('ventas')->name('ventas.')->group(function () {
        Route::get('/pos', [PosController::class, 'index'])->name('pos');
        Route::post('/pos/agregar', [PosController::class, 'agregar'])->name('pos.agregar');
        Route::post('/pos/cobrar', [PosController::class, 'cobrar'])->name('pos.cobrar');
        Route::get('/', [VentaController::class, 'index'])->name('index');
        Route::get('/{venta}', [VentaController::class, 'show'])->name('show');
    });

    // ==================== INVENTARIO ====================
    Route::resource('productos', ProductoController::class);
    Route::resource('categorias', CategoriaController::class);
    Route::resource('lotes', LoteController::class);

    // ==================== COMPRAS ====================
    Route::resource('compras', CompraController::class);
    Route::resource('proveedores', ProveedorController::class);

    // ==================== RECETAS ====================
    Route::resource('recetas', RecetaController::class);

    // ==================== ALERTAS ====================
    Route::get('/alertas', [AlertaController::class, 'index'])->name('alertas.index');
    Route::post('/alertas/{alerta}/leer', [AlertaController::class, 'marcarLeida'])->name('alertas.leer');

    // ==================== REPORTES ====================
    Route::prefix('reportes')->name('reportes.')->group(function () {
        Route::get('/ventas', [ReporteController::class, 'ventas'])->name('ventas');
        Route::get('/inventario', [ReporteController::class, 'inventario'])->name('inventario');
        Route::get('/productos-vendidos', [ReporteController::class, 'productosVendidos'])->name('productos-vendidos');
    });

    // ==================== ADMINISTRACIÓN ====================
    Route::resource('usuarios', UsuarioController::class);
    Route::get('/perfil', [PerfilController::class, 'ver'])->name('perfil');
    Route::put('/perfil', [PerfilController::class, 'actualizar'])->name('perfil.actualizar');
});