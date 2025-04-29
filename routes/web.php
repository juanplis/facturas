<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Facturas;

// Ruta para acceder al método index del controlador Facturas
Route::get('/', [Facturas::class, 'login'])->name('welcome');
Route::post('/factura/index', [Facturas::class, 'usuarios'])->name('usuario');
//Route::get('/factura/index', [Facturas::class, 'index'])->name('factura.index');
Route::get('/factura/presupuesto', [Facturas::class, 'buscar'])->name('buscar'); // Cambiar el nombre
Route::post('/factura/cargar', [Facturas::class, 'cargar'])->name('factura.carga');
