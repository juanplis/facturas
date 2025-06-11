<?php

use App\Http\Controllers\ClientesController;
use App\Http\Controllers\EditarController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Facturas;
use App\Http\Controllers\ListaController;
use App\Http\Controllers\PresupuestoController;
use App\Http\Controllers\ContactoController;

// Ruta para acceder al método index del controlador Facturas
Route::get('/login', [Facturas::class, 'login'])->name('welcome');
Route::post('/factura/index', [Facturas::class, 'usuarios'])->name('usuario');
Route::get('/factura/index', [Facturas::class, 'index'])->name('factura.index');

Route::get('/factura/presupuestoStell', [Facturas::class, 'buscar'])->name('buscar');
Route::post('/factura/cargar', [Facturas::class, 'cargar'])->name('factura.carga');
Route::post('/contactos', [ContactoController::class, 'store'])->name('contactos.store');

Route::get('/factura/editar/{id}', [Facturas::class, 'editar'])->name('factura.edita');
Route::put('/factura/index/{id}', [Facturas::class, 'update'])->name('factura.update');
Route::get('/factura/ver/{id}', [Facturas::class, 'ver'])->name('factura.ver');
Route::delete('/factura/index/{id}', [Facturas::class, 'eliminar'])->name('factura.elimina');

// Ruta para acceder al método index del controlador Clientes
Route::get('/cliente/index', [ClientesController::class, 'index'])->name('user.index');
Route::get('/cliente/crear', [ClientesController::class, 'crear'])->name('user.crear');
Route::post('/cliente/cargar', [ClientesController::class, 'store'])->name('user.store');
Route::get('/cliente/editar/{id}', [ClientesController::class, 'editar'])->name('user.editar');
Route::put('/cliente/actualizar/{id}', [ClientesController::class, 'actualizar'])->name('user.actualiza');
Route::delete('/cliente/index/{id}', [ClientesController::class, 'eliminar'])->name('user.elimina');

Route::get('/presupuesto', [PresupuestoController::class, 'generatePDF2']);

// pdf nuevo
// routes/web.php
Route::get('/presupuestos', [PresupuestoController::class, 'index'])->name('presupuestos.index');
Route::get('/presupuestos/{id}/pdf', [PresupuestoController::class, 'generatePDF'])->name('presupuestos.pdf');


use App\Http\Controllers\EstatusPresupuestoController;

Route::get('/estatus-presupuestos', [EstatusPresupuestoController::class, 'index']);
Route::get('/estatus-presupuestos/{id}', [EstatusPresupuestoController::class, 'show']);


use App\Http\Controllers\EmpresaController;
Route::resource('empresas', EmpresaController::class);
