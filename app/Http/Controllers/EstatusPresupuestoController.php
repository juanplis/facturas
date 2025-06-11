<?php

namespace App\Http\Controllers;

use App\Models\EstatusPresupuesto;
use Illuminate\Http\Request;

class EstatusPresupuestoController extends Controller
{
    /**
     * Obtiene todos los estados de presupuesto
     */
    public function index()
    {
        $estatus = EstatusPresupuesto::select('id', 'nombre', 'estatus')
                    ->where('estatus', 1) // Filtra por estatus activo
                    ->get();

        return response()->json($estatus);
    }

    /**
     * Muestra presupuestos por estado específico
     */
    public function show($id)
    {
        $estatus = EstatusPresupuesto::with('presupuestos.items')
                    ->findOrFail($id);

        return response()->json($estatus);
    }
}
