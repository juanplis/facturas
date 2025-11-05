<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TasaBcv; // Asumiendo el modelo
use App\Models\PorcentajeInventario; // Asumiendo el modelo


class PorcentajeController extends Controller
{


    public function store(Request $request)
    {
        // Validar el porcentaje
        $request->validate([
            'porcentaje' => 'required|numeric|min:0', // Asegúrate de que sea un número positivo
        ]);

        // Crear un nuevo registro de porcentaje
        $porcentaje = new PorcentajeInventario();
        $porcentaje->porcentaje = $request->porcentaje; // Asumiendo que el campo en la base de datos se llama 'valor'
        $porcentaje->save();

        // Redireccionar a la vista anterior con un mensaje de éxito
        return redirect()->back()->with('success', 'Porcentaje guardado exitosamente.');
    }
}
