<?php

namespace App\Http\Controllers; // Namespace correcto para los controladores

use Illuminate\Http\Request;
use App\Models\Presupuesto;
use App\Models\Inventario;
use App\Models\Clientes;
use App\Models\Items;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Controller;

class Facturas extends Controller{


    public function invoke()
    {
        // Lógica para mostrar la vista de bienvenida
        return view('welcome'); // Asegúrate de que la vista exista
    }

    public function index()
    {
        return view('factura.index'); // Asegúrate de que el archivo index.blade.php esté en resources/views/factura
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
        'id' => 'sometimes|integer',
        'Cliente_ID' => 'required|integer',
        'Fecha' => 'required|date',
        'Subtotal' => 'required|numeric',
        'Total' => 'required|numeric',
        'Condiciones_Pago' => 'nullable|string',
        'Validez' => 'nullable|date',
        'Descripcion' => 'required|array',
        'cantidad' => 'required|array'
    ]);

    // Cargar todos los clientes e inventarios para la vista
    $clientes = Clientes::all();
    $inventarios = Inventario::all();

    // Si se proporciona un ID, se intenta actualizar el registro existente
    if ($request->has('id')) {
        $presupuesto = Presupuesto::with('items')->find($request->id); // Cargar Items relacionados
        if ($presupuesto) {
            $presupuesto->update([
                'Cliente_ID' => $request->Cliente_ID,
                'Fecha' => $request->Fecha,
                'Subtotal' => $request->Subtotal,
                'Total' => $request->Total,
                'Condiciones_Pago' => $request->Condiciones_Pago ?: null,
                'Validez' => $request->Validez ?: null,
            ]);

            // Actualizar los items del presupuesto
            foreach ($request->Descripcion as $index => $descripcionId) {
                $cantidad = $request->cantidad[$descripcionId];
                $precioUnitario = Inventario::find($descripcionId)->Precio_Unitario;
                $precioTotal = $cantidad * $precioUnitario;

                Items::updateOrCreate(
                    ['Presupuesto_ID' => $presupuesto->ID, 'Codigo' => $descripcionId],
                    [
                        'Descripcion' => $request->Descripcion[$index],
                        'Cantidad' => $cantidad,
                        'Precio_Unitario' => $precioUnitario,
                        'Precio_Total' => $precioTotal
                    ]
                );
            }

            return redirect()->back()->with('success', 'Presupuesto actualizado con éxito.');
        } else {
            return redirect()->back()->withErrors(['error' => 'Presupuesto no encontrado.']);
        }
    } else {
        // Si no se proporciona un ID, se crea un nuevo registro
        $presupuesto = Presupuesto::create([
            'Cliente_ID' => $request->Cliente_ID,
            'Fecha' => $request->Fecha,
            'Subtotal' => $request->Subtotal,
            'Total' => $request->Total,
            'Condiciones_Pago' => $request->Condiciones_Pago ?: null,
            'Validez' => $request->Validez ?: null,
        ]);

        // Crear los items del presupuesto
        foreach ($request->Descripcion as $index => $descripcionId) {
            $cantidad = $request->cantidad[$descripcionId];
            $precioUnitario = Inventario::find($descripcionId)->Precio_Unitario;
            $precioTotal = $cantidad * $precioUnitario;

            Items::create([
                'Presupuesto_ID' => $presupuesto->ID,
                'Codigo' => $descripcionId,
                'Descripcion' => $request->Descripcion[$index],
                'Cantidad' => $cantidad,
                'Precio_Unitario' => $precioUnitario,
                'Precio_Total' => $precioTotal
            ]);
        }

        // Cargar Items para mostrar en la vista
        $items = Items::where('Presupuesto_ID', $presupuesto->ID)->get();

        return view('factura.cargar', [
            'clientes' => $clientes,
            'inventarios' => $inventarios,
            'presupuesto' => $presupuesto,
            'items' => $items // Pasar los items a la vista
        ]);
    }
}
}
