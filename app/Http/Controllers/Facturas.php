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
use App\Models\Empresa;

use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Controller;
use Session;

class Facturas extends Controller{


    public function login()
    {
        // Lógica para mostrar la vista de bienvenida
        return view('welcome'); // Asegúrate de que la vista exista
    }

    public function indexqq()
{

    $presupuestos = Presupuesto::all(); // Obtén todos los elementos de la lista
    return view('factura.index', compact('presupuestos')); // Pasa la variable a la vista



}
public function index()
{
    $presupuestos = Presupuesto::with('estado')->get(); // Relación "estado"
    return view('factura.index', compact('presupuestos'));
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



   public function buscar(Request $request, $id)
{
    // Obtener todos los clientes
    $clientes = Clientes::all(); // Cambié $cliente a $clientes para mayor claridad

    // Obtener productos
    $inventarios = Inventario::all(); // Cambié $inventario a $inventarios para mayor claridad

    // Buscar la empresa por ID
    // Obtener empresas que coincidan con el ID recibido
    $empresas = Empresa::where('id', $id)->get();

    // Verificar si se encontró la empresa
    if ($empresas->isEmpty()) {
        return redirect()->back()->withErrors(['error' => 'Empresa no encontrada.']);
    }

    // Retornar la vista con los datos necesarios
    return view('factura.presupuesto', compact('clientes', 'inventarios', 'empresas'));
}


/*public function cargar(request $request)
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
    $clientes = clientes::all();
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

                items::updateOrCreate(
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
            return redirect()->back()->withErrors(['error' => 'presupuesto no encontrado.']);
        }
    } else {
        // si no se proporciona un id, se crea un nuevo registro
        $presupuesto = presupuesto::create([
            'cliente_id' => $request->cliente_id,
            'fecha' => $request->fecha,
            'subtotal' => $request->subtotal,
            'total' => $request->total,
            'condiciones_pago' => $request->condiciones_pago ?: null,
            'validez' => $request->validez ?: null,
            'status' => 1 // Establecer el estado en 1 al crear un nuevo presupuesto
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
            'presupuesto' => $presupuesto,
            'items' => $items // pasar los items a la vista
        ]);
    }
}*/



public function cargar(Request $request)
    {
        // 1. Validar los datos recibidos
        $request->validate([
            'cliente_id' => 'required|integer',
            'fecha' => 'required|date',
            'subtotal' => 'required|numeric',
            'total' => 'required|numeric',
            'condiciones_pago' => 'nullable|string',
            'validez' => 'nullable|date',
            'descripcion' => 'required|array', // Array de IDs de productos
            'cantidad' => 'required|array',     // Array asociativo de cantidades
            'empresa_id' => 'required|integer'  // Validar el campo oculto de la empresa
        ]);

        // 2. Crear un nuevo registro de Presupuesto
        $presupuesto = Presupuesto::create([
            'cliente_id' => $request->cliente_id,
            'fecha' => $request->fecha,
            'subtotal' => $request->subtotal,
            'total' => $request->total,
            'condiciones_pago' => $request->condiciones_pago ?: null, // Usa null si está vacío
            'validez' => $request->validez ?: null,                   // Usa null si está vacío
            'empresa_id' => $request->empresa_id, // Guardar empresa_id al crear
            'status' => 1 // Establecer el estado en 1 por defecto al crear
        ]);

        // 3. Crear los ítems asociados a este presupuesto
        foreach ($request->descripcion as $index => $descripcionid) {
            // Asegúrate de que $descripcionid es el ID del inventario
            $cantidad = $request->cantidad[$descripcionid];

            // Obtener el precio unitario del inventario
            $inventarioItem = Inventario::find($descripcionid);
            if (!$inventarioItem) {
                // Manejar el caso de que el producto no exista (opcional, pero buena práctica)
                return redirect()->back()->withErrors(['error' => "El producto con ID {$descripcionid} no fue encontrado."]);
            }
            $preciounitario = $inventarioItem->precio_unitario;
            $preciototal = $cantidad * $preciounitario;

            Items::create([
                'presupuesto_id' => $presupuesto->id,
                'codigo' => $descripcionid, // Aquí 'codigo' parece ser el ID del producto
                'descripcion' => $inventarioItem->descripcion, // Usar la descripción del inventario
                'cantidad' => $cantidad,
                'precio_unitario' => $preciounitario,
                'precio_total' => $preciototal
            ]);
        }

        // 4. Cargar los ítems recién creados para mostrarlos en la vista de confirmación
        // Opcional: Eager load la empresa y el cliente si los necesitas en la vista 'factura.cargar'
        $presupuesto->load(['items', 'cliente', 'empresa']);

        // 5. Retornar la vista con los datos del presupuesto y sus ítems
        return view('factura.cargar', [
            'presupuesto' => $presupuesto,
            'items' => $presupuesto->items // Ahora los ítems están cargados en el presupuesto
        ])->with('success', 'Presupuesto creado con éxito.'); // Mensaje de éxito
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

 public function update(Request $request, $id)
    {
        // Validar los datos
        $request->validate([
            'cliente_id' => 'required|integer',
            'producto_id' => 'required|array',
            'producto_id.*' => 'required|integer',
            'cantidad' => 'required|array',
            'cantidad.*' => 'required|integer|min:1',
            'subtotal' => 'required|numeric',
            'total' => 'required|numeric',
            'fecha' => 'required|date',
            'validez' => 'nullable|date',
            'condiciones_pago' => 'nullable|string',
        ]);

        // Cargar el presupuesto
        $presupuesto = Presupuesto::find($id);
        if (!$presupuesto) {
            return redirect()->route('factura.index')->with('error', 'Presupuesto no encontrado.');
        }

        // Actualizar los datos del presupuesto
        $presupuesto->update([
            'cliente_id' => $request->cliente_id,
            'subtotal' => $request->subtotal,
            'total' => $request->total,
            'fecha' => $request->fecha,
            'validez' => $request->validez,
            'condiciones_pago' => $request->condiciones_pago,
        ]);

        // Eliminar los ítems existentes
        $presupuesto->items()->delete(); // Cambiar detach() por delete()

        // Agregar nuevos ítems
        foreach ($request->producto_id as $productoId) {
            $cantidad = $request->cantidad[$productoId];
            $precioUnitario = Inventario::find($productoId)->precio_unitario;
            $precioTotal = $cantidad * $precioUnitario;

            // Crear los nuevos ítems
            $presupuesto->items()->create([
                'codigo' => $productoId,
                'cantidad' => $cantidad,
                'precio_unitario' => $precioUnitario,
                'precio_total' => $precioTotal,
            ]);
        }

        return redirect()->route('factura.index')->with('success', 'Presupuesto actualizado correctamente.');
    }
}
