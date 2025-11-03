<?php

namespace App\Http\Controllers;

use App\Models\Estatus;
use Illuminate\Http\Request;

class EstatusController extends Controller
{
    public function mostrarNombre($id)
    {
        $estatus = Estatus::find($id);

        if ($estatus) {
            return response()->json(['nombre' => $estatus->nombre]);
        } else {
            return response()->json(['error' => 'Estatus no encontrado'], 404);
        }
    }
}