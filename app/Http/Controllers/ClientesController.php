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
            return view('clientes.crear'); // Pasar datos a la vista
    }
    public function store(Request $request)
{
    // Validación de datos
    $request->validate([
        'nombre' => 'required|string',
        'rif' => 'required|string',
        'direccion' => 'required|string',
        'telefono' => 'required|string',
        'correo' => 'required|email',
    ]);

    // Crear nuevo cliente
    $cliente = new Clientes();
    $cliente->nombre = $request->nombre;
    $cliente->rif = $request->rif;
    $cliente->direccion = $request->direccion;
    $cliente->telefono = $request->telefono;
    $cliente->correo = $request->correo;
    $cliente->save();

    return redirect()->route('user.index')->with('success', 'Cliente creado correctamente.');
}

    public function actualizar(Request $request, $id) // Cambiar 'request' a 'Request' y agregar $id
    {
        // Validación de datos
        $request->validate([
            'nombre' => 'required|string',
            'rif' => 'required|string',
            'direccion' => 'required|string',
            'telefono' => 'required|string',
            'correo' => 'required|email',
        ]);

        // Buscar el cliente por ID
        $cliente = Clientes::findOrFail($id);

        // Actualiza los datos
        $cliente->nombre = $request->nombre;
        $cliente->rif = $request->rif;
        $cliente->direccion = $request->direccion;
        $cliente->telefono = $request->telefono;
        $cliente->correo = $request->correo;
        
        // Guarda los cambios
        $cliente->save();

        return redirect()->route('user.index')->with('success', 'Cliente actualizado correctamente.');
    }

    public function editar($id)
    {
        $cliente = Clientes::find($id);
        if (!$cliente) {
            return redirect()->route('user.index')->with('error', 'Cliente no encontrado.');
        }
        return view('clientes.editar', compact('cliente'));
    }

    public function eliminar($id)
    {
        $cliente = Clientes::find($id);
        if ($cliente) {
            $cliente->delete();
            return redirect()->back()->with('success', 'Cliente eliminado con éxito.');
        }
        return redirect()->back()->with('error', 'Cliente no encontrado.');
    }
}
