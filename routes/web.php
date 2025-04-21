<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Facturas;

// Ruta para acceder al método index del controlador Facturas
Route::get('/welcome', [Facturas::class, 'invoke'])->name('welcome');
Route::get('/factura', [Facturas::class, 'index'])->name('factura.index');
Route::get('/factura/presupuesto', [Facturas::class, 'buscar'])->name('factura.buscar'); // Cambiar el nombre
Route::post('/factura/cargar', [Facturas::class, 'cargar'])->name('factura.cargar');
