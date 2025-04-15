<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Facturas;

// Ruta para acceder al método index del controlador TuController
Route::get('/factura', [Facturas::class, 'index'])->name('factura.index');
Route::get('/factura', [Facturas::class, 'buscar'])->name('factura.index');
Route::post('/factura/cargar', [Facturas::class, 'cargar'])->name('factura.cargar');


// rutas nuevas

use App\Http\Controllers\ClientesController;
use App\Http\Controllers\ContactoController;

Route::get('/clientes', [ClientesController::class, 'index']);
Route::get('/contacto', [ContactoController::class, 'index']);


use App\Http\Controllers\PresupuestoController;

Route::get('/presupuesto', [PresupuestoController::class, 'generatePDF']);




