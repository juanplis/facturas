<?php

namespace App\Http\Controllers;

use App\Models\Clientes;
use App\Models\Contacto;
use App\Models\Presupuesto;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ClientesController extends Controller
{
    
/*
public function index()
{
    // Obtener los clientes en orden descendente por fecha de creación
    $clientes = Clientes::orderBy('created_at', 'desc')->paginate(10); // Asegúrate de usar paginate()

    return view('clientes.index', compact('clientes')); // Asegúrate de que el nombre de la vista sea correcto
}
*/
public function index(Request $request)
{
    $query = $request->input('search');
    $clientes = Clientes::when($query, function($queryBuilder) use ($query) {
        return $queryBuilder->where('nombre', 'LIKE', "%{$query}%")
            ->orWhere('rif', 'LIKE', "%{$query}%")
            ->orWhere('direccion', 'LIKE', "%{$query}%")
            ->orWhere('telefono', 'LIKE', "%{$query}%")
            ->orWhere('correo', 'LIKE', "%{$query}%");
    })->orderBy('created_at', 'desc')->paginate(10);

    return view('clientes.index', compact('clientes'));
}
  
  /* public function index()
    {
        $clientes = Clientes::all(); // Obtener todos los clientes
        return view('clientes.index', compact('clientes')); // Pasar datos a la vista
    }*/

    public function crear()
    {
            return view('clientes.crear'); // Pasar datos a la vista
    }
  
  
  

   /*  public function store(Request $request)
    {
        // Validación de datos
        $request->validate([
            'nombre' => 'required|string',
            'rif' => 'required|string',
            'direccion' => 'required|string',
            'telefono' => 'required|string',
            'correo' => 'nullable|email|string',
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
       
      // dd($contacto);

        return redirect()->route('user.index')->with('success', 'Cliente y contacto creados correctamente.');
    }
*/
  
  
  public function store(Request $request)
{
    // Validación de datos
    $request->validate([
        'nombre' => 'required|string',
        'rif' => 'required|string',
        'direccion' => 'required|string',
        'telefono' => 'required|string',
        'correo' => 'nullable|email|string',
        'nombre_contacto' => 'required|string',
        'telefono_contacto' => 'required|string',
        'correo_contacto' => 'required|email',
    ]);

    try {
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
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Error al guardar: ' . $e->getMessage());
    }
}

  
  
  
public function editar($id)
{
    // Buscar el cliente y su contacto asociado
    $cliente = Clientes::with('contacto')->find($id);
    
    // Verificar si el cliente existe
    if (!$cliente) {
        return redirect()->route('user.index')->with('error', 'Cliente no encontrado.');
    }

    // Obtener el contacto asociado al cliente
    $contacto = $cliente->cliente_id; // Ahora esto obtendrá el contacto relacionado

    // Pasar el cliente y el contacto a la vista
    return view('clientes.editar', compact('cliente', 'contacto'));
}

  
   /* public function editar($id)
    {
        $cliente = Clientes::find($id);
        if (!$cliente) {
            return redirect()->route('user.index')->with('error', 'Cliente no encontrado.');
        }
        return view('clientes.editar', compact('cliente'));
    }*/
  
  
  /*	public function actualizar(Request $request, $id) 
{
    // Validación de datos
    $request->validate([
        'nombre' => 'required|string|max:255', // Agregando un límite de caracteres
        'rif' => 'required|string|max:20', // Ajusta según el formato esperado
        'direccion' => 'required|string|max:255', // Agregando un límite de caracteres
        'telefono' => 'required|string|max:15', // Ajusta según el formato esperado
        'correo' => 'required|email|max:255', // Agregando un límite de caracteres
        'nombre_contacto' => 'required|string|max:255', // Validación para contacto
        'telefono_contacto' => 'required|string|max:15', // Validación para contacto
        'correo_contacto' => 'nullable|email|max:255', // Validación opcional para contacto
    ]);

    // Buscar el cliente por ID
    $cliente = Clientes::findOrFail($id);

    // Actualiza los datos
    $cliente->nombre = $request->nombre;
    $cliente->rif = $request->rif;
    $cliente->direccion = $request->direccion;
    $cliente->telefono = $request->telefono;
    $cliente->correo = $request->correo;

    // Actualiza los datos del contacto
    $cliente->nombre_contacto = $request->nombre_contacto;
    $cliente->telefono_contacto = $request->telefono_contacto;
    $cliente->correo_contacto = $request->correo_contacto;

    // Guarda los cambios
    $cliente->save();

    // Redirige con un mensaje de éxito
    return redirect()->route('user.index')->with('success', 'Cliente actualizado correctamente.');
}*/

  
public function actualizar(Request $request, $id)
{
    // Validación de datos
    $request->validate([
        'nombre' => 'required|string',
        'rif' => 'required|string',
        'direccion' => 'required|string',
        'telefono' => 'required|string',
        'correo' => 'required|string', // Cambiado a string
        'nombre_contacto' => 'required|string',
        'telefono_contacto' => 'required|string',
        'correo_contacto' => 'nullable|string', // Cambiado a string
    ]);

    // Buscar el cliente por ID
    $cliente = Clientes::findOrFail($id);

    // Actualizar datos del cliente
    $cliente->nombre = $request->nombre;
    $cliente->rif = $request->rif;
    $cliente->direccion = $request->direccion;
    $cliente->telefono = $request->telefono;
    $cliente->correo = $request->correo;
    $cliente->save(); // Guarda los cambios del cliente

    // Buscar el contacto asociado al cliente
    $contacto = Contacto::where('cliente_id', $cliente->id)->first();

    if ($contacto) {
        // Actualizar datos del contacto
        $contacto->nombre = $request->nombre_contacto;
        $contacto->telefono = $request->telefono_contacto;
        $contacto->correo = $request->correo_contacto; // Cambiado a string
        $contacto->save(); // Guarda los cambios del contacto

        return redirect()->route('user.index')->with('success', 'Cliente y contacto actualizados correctamente.');
    } else {
        // Manejo de error si no se encuentra el contacto
        return redirect()->route('user.index')->with('error', 'El contacto no fue encontrado para actualizar.');
    }
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
