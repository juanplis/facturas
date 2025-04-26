<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Facturas;

// Ruta para acceder al método index del controlador Facturas
Route::get('/login', [Facturas::class, 'login'])->name('welcome');
Route::get('/factura', [Facturas::class, 'usuarios'])->name('usuarios');
Route::get('/factura/index', [Facturas::class, 'index'])->name('factura.index');
Route::get('/factura/presupuesto', [Facturas::class, 'buscar'])->name('factura.buscar'); // Cambiar el nombre
Route::post('/factura/cargar', [Facturas::class, 'cargar'])->name('factura.cargar');
