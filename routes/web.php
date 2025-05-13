<?php

use App\Http\Controllers\ClientesController;
use App\Http\Controllers\EditarController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Facturas;
use App\Http\Controllers\ListaController;
use App\Http\Controllers\PresupuestoController;

// Ruta para acceder al método index del controlador Facturas
Route::get('/login', [Facturas::class, 'login'])->name('welcome');
Route::post('/factura/index', [Facturas::class, 'usuarios'])->name('usuario');
Route::get('/factura/index', [Facturas::class, 'index'])->name('factura.index');
Route::get('/factura/presupuesto', [Facturas::class, 'buscar'])->name('buscar');
Route::post('/factura/cargar', [Facturas::class, 'cargar'])->name('factura.carga');


Route::get('/factura/editar/{id}', [EditarController::class, 'editar'])->name('factura.edita');
Route::put('/factura/index/{id}', [Facturas::class, 'update'])->name('factura.update');
Route::get('/factura/show/{id}', [Facturas::class, 'show'])->name('factura.show');


Route::get('/cliente/index', [ClientesController::class, 'index'])->name('user.index');
Route::get('/cliente/crear', [ClientesController::class, 'crear'])->name('user.crear');
Route::post('/cliente/cargar', [ClientesController::class, 'update'])->name('user.update');



//Route::put('/cliente/crear/{id}', [ClientesController::class, 'update'])->name('user.update');




Route::get('/presupuesto', [PresupuestoController::class, 'generatePDF2']);

// pdf nuevo
// routes/web.php
Route::get('/presupuestos', [PresupuestoController::class, 'index'])->name('presupuestos.index');
Route::get('/presupuestos/{id}/pdf', [PresupuestoController::class, 'generatePDF'])->name('presupuestos.pdf');
