<?php

namespace App\Http\Controllers;

use App\Models\Presupuesto;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class EditarController extends Controller
{
    public function editar($request)
    {
        $presupuesto = Presupuesto ::all(); // Obtener todos los clientes
        return view('factura.editar', compact('presupuesto')); // Pasar datos a la vista
    }
}
