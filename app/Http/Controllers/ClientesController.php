<?php

namespace App\Http\Controllers;

use App\Models\Clientes;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ClientesController extends Controller
{
    public function index()
    {
        $clientes = Clientes::all(); // Obtener todos los clientes
        return view('clientes.index', compact('clientes')); // Pasar datos a la vista
    }

      public function crear()
    {
        //$clientes = Clientes::all(); // Obtener todos los clientes
        return view('clientes.crear'); // Pasar datos a la vista
    }

   public function update(request $request) // Cambiar 'request' a 'Request'
{
    $request->validate([
        'id' => 'sometimes|integer',
        'nombre' => 'required|string', // Cambiar 'varchar' a 'string'
        'rif' => 'required|string', // Cambiar 'varchar' a 'string'
        'direccion' => 'required|string', // Cambiar 'varchar' a 'string'
        'telefono' => 'required|string', // Cambiar 'varchar' a 'string'
        'correo' => 'required|email', // Cambiar 'varchar' a 'email'
    ]);

    // Crear un nuevo registro
        Clientes::create([

        'nombre' => $request->nombre,
        'rif' => $request->rif,
        'direccion' => $request->direccion,
        'telefono' => $request->telefono,
        'correo' => $request->correo,
    ]);

    return redirect()->route('user.index')->with('success', 'Cliente creado correctamente.'); // Mensaje corregido
}

/*




    public function editar(Request $request, $id)
    {
    $cliente = Clientes::find($id); // 

    // Valida los datos
    $request->validate([
        'id' => 'required|integer',
        'nombre' => 'required|varchar',
        'rif' => 'required|varchar',
        'direccion' => 'required|varchar',
        'telefono' => 'required|varchar',
        'correo' => 'required|varchar',
        // Agrega más validaciones según sea necesario
    ]);

    // Actualiza los datos
    $cliente->id = $request->id;
    $cliente->nombre = $request->nombre;
    $cliente->rif = $request->rif;
    $cliente->direccion = $request->direccion;
    $cliente->telefono = $request->telefono;
    $cliente-> correo= $request->correo;
    // Actualiza otros campos según sea necesario
    $cliente->save(); // Guarda los cambios

    return redirect()->route('user.index')->with('success', 'Presupuesto actualizado correctamente.');
    }
*/
}
