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
        'porcentaje' => 'required|numeric|min:0|max:100', // Asegúrate de que sea un número positivo y dentro del rango 0-100
    ]);

    try {
        // Crear un nuevo registro de porcentaje
        $porcentaje = new PorcentajeInventario();
        $porcentaje->porcentaje = $request->porcentaje; // Asegúrate de que este campo sea correcto
        $porcentaje->save();

        // Devolver respuesta JSON de éxito
        return response()->json(['success' => true, 'message' => 'Porcentaje guardado exitosamente.']);
    } catch (\Exception $e) {
        // Capturar cualquier error y devolver respuesta de error
        return response()->json(['success' => false, 'message' => 'Error al guardar el porcentaje: ' . $e->getMessage()]);
    }
}

}
