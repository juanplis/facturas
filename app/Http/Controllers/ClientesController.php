<?php

namespace App\Http\Controllers;

use App\Models\Clientes;
use App\Models\Contacto;
use App\Models\Presupuesto;
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
            'nombre_contacto' => 'required|string',
            'telefono_contacto' => 'required|string',
            'correo_contacto' => 'required|email',
        ]);

        // Crear nuevo cliente
        $cliente = new Clientes();
        $cliente->nombre = $request->nombre;
        $cliente->rif = $request->rif;
        $cliente->direccion = $request->direccion;
        $cliente->telefono = $request->telefono;
        $cliente->correo = $request->correo;
        $cliente->save();

        // Crear nuevo contacto asociado al cliente
        $contacto = new Contacto();
        $contacto->cliente_id = $cliente->id; // Asocia el contacto al nuevo cliente
        $contacto->nombre = $request->nombre_contacto;
        $contacto->telefono = $request->telefono_contacto;
        $contacto->correo = $request->correo_contacto;
        $contacto->save();

        return redirect()->route('user.index')->with('success', 'Cliente y contacto creados correctamente.');
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
        // Verificar si hay presupuestos relacionados con el cliente
        $presupuesto = Presupuesto::where('cliente_id', $id)->count();

        if ($presupuesto > 0) {
            // Si hay presupuestos, retornar un mensaje de error
            return redirect()->back()->with('error', 'El cliente tiene presupuestos asociados. Debe eliminarlos antes de eliminar el cliente.');
        }

        // Luego, eliminar los contactos relacionados con el cliente
        Contacto::where('cliente_id', $id)->delete();

        // Finalmente, eliminar el cliente
        $cliente->delete();

        return redirect()->back()->with('success', 'Cliente y sus datos eliminados con éxito.');
    }
    return redirect()->back()->with('error', 'Cliente no encontrado.');
}


}
