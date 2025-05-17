<?php

namespace App\Http\Controllers; // Namespace correcto para los controladores
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Presupuesto;
use App\Models\Inventario;
use App\Models\Clientes;
use App\Models\Usuarios;
use App\Models\Items;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Controller;
use Session;

class Facturas extends Controller{


    public function login()
    {
        // Lógica para mostrar la vista de bienvenida
        return view('welcome'); // Asegúrate de que la vista exista
    }

    public function index()
{
    $presupuestos = Presupuesto::all(); // Obtén todos los elementos de la lista
    return view('factura.index', compact('presupuestos')); // Pasa la variable a la vista
}


    public function usuarios(Request $request)
{
    // Validar los datos de entrada
    $request->validate([
        'name' => 'required|string',
        'password' => 'required|string',
    ]);

    // Buscar el usuario por nombre
    $usuario = Usuarios::where('name', $request->name)->first();

    // Verificar si el usuario existe y si la contraseña es correcta
    if ($usuario && Hash::check($request->password, $usuario->password)) {
        // Las credenciales son correctas
        return redirect()->route('factura.index'); // Redirigir a la vista factura.index
    } else {
        // Las credenciales son incorrectas
        return back()->withErrors([
            'name' => 'El nombre de usuario o la contraseña son incorrectos.',
        ]);
    }
}



    public function buscar(Request $request)
{
    // Obtener todos los clientes
    $clientes = Clientes::all(); // Cambié $cliente a $clientes para mayor claridad

    // Obtener productos
    $inventarios = Inventario::all(); // Cambié $inventario a $inventarios para mayor claridad

    // Retornar la vista con los datos necesarios
    return view('factura.presupuesto', compact('clientes', 'inventarios'));
}

public function cargar(request $request)
{
    // validar los datos recibidos
    $request->validate([
        'id' => 'sometimes|integer',
        'cliente_id' => 'required|integer',
        'fecha' => 'required|date',
        'subtotal' => 'required|numeric',
        'total' => 'required|numeric',
        'condiciones_pago' => 'nullable|string',
        'validez' => 'nullable|date',
        'descripcion' => 'required|array',
        'cantidad' => 'required|array'
    ]);

   // cargar todos los clientes e inventarios para la vista
   /* $clientes = clientes::all();
    $inventarios = inventario::all();

    // si se proporciona un id, se intenta actualizar el registro existente
    if ($request->has('id')) {
        $presupuesto = presupuesto::with('items')->find($request->id); // cargar items relacionados
        if ($presupuesto) {
            $presupuesto->update([
                'cliente_id' => $request->cliente_id,
                'fecha' => $request->fecha,
                'subtotal' => $request->subtotal,
                'total' => $request->total,
                'condiciones_pago' => $request->condiciones_pago ?: null,
                'validez' => $request->validez ?: null,
            ]);

            // actualizar los items del presupuesto
            foreach ($request->descripcion as $index => $descripcionid) {
                $cantidad = $request->cantidad[$descripcionid];
                $preciounitario = inventario::find($descripcionid)->precio_unitario;
                $preciototal = $cantidad * $preciounitario;

                items::updateorcreate(
                    ['presupuesto_id' => $presupuesto->id, 'codigo' => $descripcionid],
                    [
                        'descripcion' => $request->descripcion[$index],
                        'cantidad' => $cantidad,
                        'precio_unitario' => $preciounitario,
                        'precio_total' => $preciototal
                    ]
                );
            }

            return redirect()->back()->with('success', 'presupuesto actualizado con éxito.');
        } else {
            return redirect()->back()->witherrors(['error' => 'presupuesto no encontrado.']);
        }
    } else {*/
        // si no se proporciona un id, se crea un nuevo registro
        $presupuesto = presupuesto::create([
            'cliente_id' => $request->cliente_id,
            'fecha' => $request->fecha,
            'subtotal' => $request->subtotal,
            'total' => $request->total,
            'condiciones_pago' => $request->condiciones_pago ?: null,
            'validez' => $request->validez ?: null,
        ]);

        // crear los items del presupuesto
        foreach ($request->descripcion as $index => $descripcionid) {
            $cantidad = $request->cantidad[$descripcionid];
            $preciounitario = inventario::find($descripcionid)->precio_unitario;
            $preciototal = $cantidad * $preciounitario;

            items::create([
                'presupuesto_id' => $presupuesto->id,
                'codigo' => $descripcionid,
                'descripcion' => $request->descripcion[$index],
                'cantidad' => $cantidad,
                'precio_unitario' => $preciounitario,
                'precio_total' => $preciototal
            ]);
        }

        // cargar items para mostrar en la vista
        $items = items::where('presupuesto_id', $presupuesto->id)->get();

        return view('factura.cargar', [
            /*'clientes' => $clientes,
            'inventarios' => $inventarios,*/
            'presupuesto' => $presupuesto,
            'items' => $items // pasar los items a la vista
        ]);
    }
  public function update(Request $request, $id)
{

     // Valida los datos
    $request->validate([
        'cliente_id' => 'required|integer',
        'fecha' => 'required|date',
        'subtotal' => 'required|numeric',
        'total' => 'required|numeric',
        'condiciones_pago' => 'nullable|string',
        'validez' => 'nullable|date',
        'descripcion' => 'required|array',
        'cantidad' => 'required|array',
        'cantidad.*' => 'required|integer|min:1', // Validar cada cantidad
    ]);

    // Encuentra el presupuesto por ID
    $presupuesto = Presupuesto::with('items')->find($id); // Cargar items relacionados

    if (!$presupuesto) {
        return redirect()->route('factura.index')->with('error', 'Presupuesto no encontrado.');
    }


    // Actualiza los datos del presupuesto
    $presupuesto->cliente_id = $request->cliente_id;
    $presupuesto->fecha = $request->fecha;
    $presupuesto->subtotal = $request->subtotal;
    $presupuesto->total = $request->total;
    $presupuesto->condiciones_pago = $request->condiciones_pago ?: null;
    $presupuesto->validez = $request->validez ?: null;

    // Guardar el presupuesto actualizado
    $presupuesto->save();

    // Eliminar items existentes
    $presupuesto->items()->delete();

    // Agregar nuevos items y sus cantidades
    foreach ($request->descripcion as $index => $descripcionid) {
        $cantidad = $request->cantidad[$descripcionid];
        $preciounitario = Inventario::find($descripcionid)->precio_unitario;
        $preciototal = $cantidad * $preciounitario;

        // Crear los nuevos items
        $presupuesto->items()->create([
            'codigo' => $descripcionid,
            'descripcion' => $request->descripcion[$index],
            'cantidad' => $cantidad,
            'precio_unitario' => $preciounitario,
            'precio_total' => $preciototal
        ]);
    }

    return redirect()->route('factura.index')->with('success', 'Presupuesto actualizado correctamente.');
}



public function ver($id)
{
    // Busca el presupuesto por ID
    $presupuesto = Presupuesto::findOrFail($id);

    // Retorna la vista con los detalles del presupuesto
    return view('factura.ver', compact('presupuesto'));
}


public function eliminar($id)
{
    $presupuesto = Presupuesto::find($id);
    if ($presupuesto) {
        // Primero, eliminar los items relacionados con el presupuesto
        items::where('presupuesto_id', $id)->delete();

        // Luego, eliminar el presupuesto
        $presupuesto->delete();

        return redirect()->back()->with('success', 'Presupuesto y sus items eliminados con éxito.');
    }
    return redirect()->back()->with('error', 'Presupuesto no encontrado.');
}

 public function editar($id)
    {
        // Obtener el presupuesto por ID
        $presupuesto = Presupuesto::find($id);

        if (!$presupuesto) {
            return redirect()->route('factura.index')->with('error', 'Presupuesto no encontrado.');
        }

        // Obtener todos los clientes
        $clientes = Clientes::all();

        // Obtener los ítems relacionados con el presupuesto
        $items = $presupuesto->items; // Asegúrate de que la relación esté definida en el modelo Presupuesto

        // Obtener todos los productos del inventario
        $productos = Inventario::all(); // Cambia esto si necesitas filtrar productos específicos

        // Pasar datos a la vista
        return view('factura.editar', compact('presupuesto', 'clientes', 'items', 'productos'));
    }




}



