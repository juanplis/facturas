<?php

namespace App\Http\Controllers; // Namespace correcto para los controladores
use Illuminate\Support\Facades\Hash;
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
        return view('factura.index'); // Asegúrate de que el archivo index.blade.php esté en resources/views/factura
    }
    public function usuarios(Request $request)
{
    // Validar los datos recibidos
    $request->validate([
        'name' => 'required|string',
        'password' => 'required|string',
    ]);

    // Buscar el usuario por nombre
    $user = Usuarios::where('name', $request->name)->first();

    // Verificar si el usuario existe
    if ($user) {
        // Comparar la contraseña ingresada con el hash almacenado
        $hashedPassword = $user->password;

        // Comprobar si la contraseña ingresada coincide con el hash
        if (password_verify($request->password, $hashedPassword)) {
            // Iniciar sesión
            auth()->login($user);
            return redirect()->route('factura.index')->with('success', 'Inicio de sesión exitoso.');
        }
    }

    // Si las credenciales son incorrectas
    return redirect()->back()->withErrors(['name' => 'Credenciales incorrectas.']);
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



public function cargar(Request $request)
{
    // Validar los datos recibidos
    $request->validate([
        'nombre' => 'required|string',
        'fecha' => 'required|date',
        'subtotal' => 'required|numeric',
        'total' => 'required|numeric',
        'condiciones_pago' => 'nullable|string',
        'validez' => 'nullable|date',
        'descripcion' => 'required|array',
        'cantidad' => 'required|array'
    ]);

    // Crear un nuevo presupuesto
    $presupuesto = Presupuesto::create([
        'cliente_id' => $request->cliente_id,
        'fecha' => $request->fecha,
        'subtotal' => $request->subtotal,
        'total' => $request->total,
        'condiciones_pago' => $request->condiciones_pago ?: null,
        'validez' => $request->validez ?: null,
    ]);

    // Crear los items del presupuesto
    foreach ($request->Descripcion as $index => $descripcionId) {
        $cantidad = $request->cantidad[$descripcionId];
        $precioUnitario = Inventario::find($descripcionId)->precio_unitario;
        $precioTotal = $cantidad * $precioUnitario;

        Items::create([
            'presupuesto_id' => $presupuesto->id,
            'codigo' => $descripcionId,
            'descripcion' => $request->Descripcion[$index],
            'cantidad' => $cantidad,
            'precio_unitario' => $precioUnitario,
            'Precio_total' => $precioTotal
        ]);
    }

    // Pasar el ID del presupuesto recién creado a la vista
    return view('factura.cargara')->with([
        'id' => $presupuesto->id,
        'nombre' => $request->nombre,
        'fecha' => $request->fecha,
        'subtotal' => $request->subtotal,
        'total' => $request->total,
        'condiciones_Pago' => $request->condiciones_pago,
        'validez' => $request->Validez,
        'descripcion' => $request->descripcion,
        'cantidad' => $request->cantidad,
    ]);
}

public function cargar111(Request $request)
{
    // Validar los datos recibidos
    $request->validate([
        'cliente_id' => 'required|integer',
        'fecha' => 'required|date',
        'subtotal' => 'required|numeric',
        'total' => 'required|numeric',
        'condiciones_pago' => 'nullable|string',
        'validez' => 'nullable|date',
        'descripcion' => 'required|array',
        'cantidad' => 'required|array'
    ]);

    // Crear o actualizar el presupuesto
    $presupuesto = Presupuesto::updateOrCreate(
      //  ['id' => $request->id], // Si se proporciona un ID, se actualiza; si no, se crea uno nuevo
        [
            'cliente_id' => $request->cliente_id,
            'fecha' => $request->fecha,
            'subtotal' => $request->subtotal,
            'total' => $request->total,
            'condiciones_pago' => $request->condiciones_pago ?: null,
            'validez' => $request->validez ?: null,
        ]
    );

    // Actualizar los ítems del presupuesto
    $this->actualizarItemsPresupuesto($request, $presupuesto->id);

    // Redirigir a la vista con los datos del presupuesto
    return redirect()->route('factura.cargar', ['id' => $presupuesto->id])->with('success', 'Presupuesto guardado con éxito.');
}

private function actualizarItemsPresupuesto(Request $request, $presupuestoId)
{
    foreach ($request->descripcion as $index => $descripcion_id) {
        $cantidad = $request->cantidad[$index];
        $precio_unitario = Inventario::find($descripcion_id)->precio_unitario;
        $precio_total = $cantidad * $precio_unitario;

        Items::updateOrCreate(
            ['presupuesto_id' => $presupuestoId, 'codigo' => $descripcion_id],
            [
                'descripcion' => $request->descripcion[$index],
                'cantidad' => $cantidad,
                'precio_unitario' => $precio_unitario,
                'precio_total' => $precio_total
            ]
        );
    }
}
}
