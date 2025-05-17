<?php

namespace App\Http\Controllers;

use App\Models\Clientes;
use App\Models\Inventario;
use App\Models\Presupuesto;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class EditarController extends Controller
{
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

