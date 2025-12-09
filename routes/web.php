<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\NotificacionController;

/*
|--------------------------------------------------------------------------
| PÚBLICO
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('inicio');
Route::get('/productos', [ProductoController::class, 'index'])->name('productos');
Route::get('/nosotros', [HomeController::class, 'nosotros'])->name('nosotros');

Route::get('/productos/crear', [ProductoController::class, 'create'])->name('productos.crear');
Route::post('/productos', [ProductoController::class, 'store'])->name('productos.store');

Route::get('/productos/{id}', [ProductoController::class, 'show'])->name('productos.show');
Route::get('/productos/{id}/editar', [ProductoController::class, 'edit'])->name('productos.edit');
Route::put('/productos/{id}', [ProductoController::class, 'update'])->name('productos.update');
Route::delete('/productos/{id}', [ProductoController::class, 'destroy'])->name('productos.destroy');


/*
|--------------------------------------------------------------------------
| CARRITO
|--------------------------------------------------------------------------
*/

Route::post('/carrito/agregar/{id}', [CarritoController::class, 'agregar'])->name('carrito.agregar');
Route::get('/carrito', [CarritoController::class, 'ver'])->name('carrito.ver');
Route::delete('/carrito/eliminar/{id}', [CarritoController::class, 'eliminar'])->name('carrito.eliminar');
Route::post('/carrito/sumar/{id}', [CarritoController::class, 'sumar'])->name('carrito.sumar');
Route::post('/carrito/restar/{id}', [CarritoController::class, 'restar'])->name('carrito.restar');


/*
|--------------------------------------------------------------------------
| RUTAS AUTENTICADAS
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/checkout', [CheckoutController::class, 'form'])->name('checkout.form');
    Route::post('/checkout/procesar', [CheckoutController::class, 'procesar'])->name('checkout.procesar');

    Route::get('/compras', [CheckoutController::class, 'historial'])->name('compras.historial');
    Route::get('/compras/{id}', [CheckoutController::class, 'detalle'])->name('compras.detalle');
});


/*
|--------------------------------------------------------------------------
| AUTENTICACIÓN
|--------------------------------------------------------------------------
*/

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout']);


/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', \App\Http\Middleware\AdminMiddleware::class])->group(function () {

    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');

    // Listado de órdenes
    Route::get('/admin/ordenes', [AdminController::class, 'ordenes'])->name('admin.ordenes');

    // Ver orden
    Route::get('/admin/orden/{id}', [AdminController::class, 'verOrden'])->name('admin.orden.ver');

    // Cambiar estado
    Route::post('/admin/orden/{id}/estado', [AdminController::class, 'cambiarEstado'])->name('admin.orden.estado');

    // Eliminar orden
    Route::delete('/admin/orden/{id}', [AdminController::class, 'eliminarOrden'])->name('admin.orden.eliminar');
});






Route::get('/notificaciones', [NotificacionController::class, 'index'])
    ->middleware('auth')
    ->name('notificaciones');