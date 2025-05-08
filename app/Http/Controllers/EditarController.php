<?php

namespace App\Http\Controllers;

use App\Models\Presupuesto;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class EditarController extends Controller
{
    public function editar($id)
    {
        $presupuesto = Presupuesto ::find($id); // Obtener todos los clientes
        return view('factura.editar', compact('presupuesto')); // Pasar datos a la vista
    }
}
