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
    public function index()
    {
        return view('factura.index'); // Asegúrate de que el archivo index.blade.php esté en resources/views/factura
    }


    public function buscar(Request $request)
    {
        // Obtener todos los clientes
        $clientes = Clientes::all(); // O usar ->get() si prefieres

        // Obtener productos
        $inventarios = Inventario::all();

        //var_dump($inventarios);

        // Retornar la vista con los datos necesarios
        return view('factura.index', [
            'clientes' => $clientes ,
            'inventarios' => $inventarios
 ]);
    }

    public function cargar(Request $request)
    {
        // Validar los datos recibidos
        $request->validate([
            'Nombre' => 'required|string',
            'Fecha' => 'required|date',
            'Subtotal' => 'required|numeric',
            'Total' => 'required|numeric',
            'Condiciones_Pago' => 'nullable|string',
            'Validez' => 'nullable|date',
            'Descripcion' => 'required|array',
            'cantidad' => 'required|array'
        ]);

        // Crear un nuevo presupuesto
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

        // Pasar el ID del presupuesto recién creado a la vista
        return view('factura.cargar')->with([
            'ID' => $presupuesto->ID,
            'Nombre' => $request->Nombre,
            'Fecha' => $request->Fecha,
            'Subtotal' => $request->Subtotal,
            'Total' => $request->Total,
            'Condiciones_Pago' => $request->Condiciones_Pago,
            'Validez' => $request->Validez,
            'Descripcion' => $request->Descripcion,
            'cantidad' => $request->cantidad,
        ]);
    }

    /*public function cargar(Request $request)
    {
        // Validar los datos recibidos
        $request->validate([
            'Nombre' => 'required|string',
            'Fecha' => 'required|date',
            'Subtotal' => 'required|numeric',
            'Total' => 'required|numeric',
            'Condiciones_Pago' => 'nullable|string',
            'Validez' => 'nullable|date',
            'Descripcion' => 'required|array',
            'cantidad' => 'required|array'
        ]);

        // Si se proporciona un ID, se intenta actualizar el registro existente
        if ($request->has('id')) {
            $presupuesto = Presupuesto::find($request->id);

            if ($presupuesto) {
                // Actualizar el presupuesto
                $presupuesto->update([
                    'Cliente_ID' => $request->Cliente_ID,
                    'Fecha' => $request->Fecha,
                    'Subtotal' => $request->Subtotal,
                    'Total' => $request->Total,
                    'Condiciones_Pago' => $request->Condiciones_Pago ?: null,
                    'Validez' => $request->Validez ?: null,
                ]);

                // Pasar el ID del presupuesto actualizado a la vista
                return view('factura.cargar')->with([
                    'ID' => $presupuesto->ID,
                    'Nombre' => $request->Nombre,
                    'Fecha' => $request->Fecha,
                    'Subtotal' => $request->Subtotal,
                    'Total' => $request->Total,
                    'Condiciones_Pago' => $request->Condiciones_Pago,
                    'Validez' => $request->Validez,
                    'Descripcion' => $request->Descripcion,
                    'cantidad' => $request->cantidad,
                ]);
            } else {
                return redirect()->back()->withErrors(['error' => 'Presupuesto no encontrado.']);
            }
        } else {
            // Crear un nuevo presupuesto
            $presupuesto = Presupuesto::create([
                'Cliente_ID' => $request->Cliente_ID,
                'Fecha' => $request->Fecha,
                'Subtotal' => $request->Subtotal,
                'Total' => $request->Total,
                'Condiciones_Pago' => $request->Condiciones_Pago ?: null,
                'Validez' => $request->Validez ?: null,
            ]);

            // Pasar el ID del presupuesto recién creado a la vista
            return view('factura.cargar')->with([
                'ID' => $presupuesto->ID,
                'Nombre' => $request->Nombre,
                'Fecha' => $request->Fecha,
                'Subtotal' => $request->Subtotal,
                'Total' => $request->Total,
                'Condiciones_Pago' => $request->Condiciones_Pago,
                'Validez' => $request->Validez,
                'Descripcion' => $request->Descripcion,
                'cantidad' => $request->cantidad,
            ]);
        }
    }*/
}
