<?php

//return;

use App\Http\Controllers\ClientesController;
use App\Http\Controllers\EditarController; // Asegúrate de que este controlador sea necesario, no se usa en las rutas proporcionadas.
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Facturas;
use App\Http\Controllers\ListaController; // Asegúrate de que este controlador sea necesario, no se usa en las rutas proporcionadas.
use App\Http\Controllers\PresupuestoController;
use App\Http\Controllers\ContactoController;
use App\Http\Controllers\InventarioController;
//use App\Http\Controllers\ProductoController;


Route::get('/', function () {
    return view('welcome');
});




// Rutas de autenticación y facturas
Route::get('/login', [Facturas::class, 'login'])->name('welcome');

Route::post('/factura/index', [Facturas::class, 'usuarios'])->name('usuario');
Route::post('/logout', [Facturas::class, 'logout'])->name('logout');

Route::get('/factura/index', [Facturas::class, 'index'])->name('factura.index');
Route::get('/factura/presupuesto{id}', [Facturas::class, 'buscar'])->name('buscar');
Route::post('/factura/cargar', [Facturas::class, 'cargar'])->name('factura.carga');
Route::get('/factura/editar/{id}', [Facturas::class, 'editar'])->name('factura.edita');
Route::put('/factura/index/{id}', [Facturas::class, 'update'])->name('factura.update');
Route::get('/factura/ver/{id}', [Facturas::class, 'ver'])->name('factura.ver');
Route::delete('/factura/index/{id}', [Facturas::class, 'eliminar'])->name('factura.elimina');

// Rutas de contactos
Route::post('/contactos', [ContactoController::class, 'store'])->name('contactos.store');


//Ruta AJAX



Route::get('/api/productos', [InventarioController::class, 'buscarProductos']);
Route::get('/api/productos/{id}', [InventarioController::class, 'obtenerProducto']);




// Rutas de Inventario (CRUD completo con Route::resource)
// Esto reemplaza: Route::get('/inventario', [InventarioController::class, 'index'])->name('inventario.index');

Route::resource('inventario', InventarioController::class);
//Route::put('/inventario/edit/{id}', [InventarioController::class, 'edit'])->name('inventario.update');
Route::put('inventario/edit/{id}', [InventarioController::class, 'update'])->name('inventario.update');
Route::post('/inventario/actualizar_precios', [InventarioController::class, 'actualizarPrecios'])->name('inventario.actualizar_precios');



// Rutas de Clientes
Route::get('/cliente/index', [ClientesController::class, 'index'])->name('user.index');
Route::get('/cliente/crear', [ClientesController::class, 'crear'])->name('user.crear');
Route::post('/cliente/cargar', [ClientesController::class, 'store'])->name('user.store');
Route::get('/cliente/editar/{id}', [ClientesController::class, 'editar'])->name('user.editar');
Route::put('/cliente/actualizar/{id}', [ClientesController::class, 'actualizar'])->name('user.actualiza');
Route::delete('/cliente/index/{id}', [ClientesController::class, 'eliminar'])->name('user.elimina');

// Rutas de Presupuestos (PDF)
Route::get('/presupuesto', [PresupuestoController::class, 'generatePDF2']);
Route::get('/presupuestos', [PresupuestoController::class, 'index'])->name('presupuestos.index');

Route::get('/presupuestos/{id}/pdf', [PresupuestoController::class, 'generatePDF'])->name('presupuestos.pdf');


use App\Http\Controllers\EstatusPresupuestoController;

Route::get('/estatus-presupuestos', [EstatusPresupuestoController::class, 'index']);
Route::get('/estatus-presupuestos/{id}', [EstatusPresupuestoController::class, 'show']);


use App\Http\Controllers\EmpresaController;
Route::resource('empresas', EmpresaController::class);


use App\Http\Controllers\TasaBcvController;
Route::resource('tasa_bcv', TasaBcvController::class);

use App\Http\Controllers\IvaController;
Route::resource('iva', IvaController::class);

use App\Http\Controllers\UserController;
Route::resource('users', UserController::class);

use App\Http\Controllers\ProfileController;
Route::resource('profile', ProfileController::class);

use App\Http\Controllers\EstatusController;

Route::get('/estatus/{id}', [EstatusController::class, 'mostrarNombre']);