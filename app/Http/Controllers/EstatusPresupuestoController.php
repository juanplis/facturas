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
    $presupuestos = Presupuesto::with('estatus_presupuesto')->get();
    return view('factura.index', compact('presupuestos'));
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
