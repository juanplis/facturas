<?php

namespace App\Http\Controllers;

use App\Models\Contacto;
use Illuminate\Http\Request;

class ContactoController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nombre_contacto' => 'required',
            'telefono_contacto' => 'required',
            'correo_contacto' => 'required|email',
            'cliente_id' => 'required|exists:clientes,id',
        ]);

        $contacto = Contacto::create([
            'nombre' => $validatedData['nombre_contacto'],
            'telefono' => $validatedData['telefono_contacto'],
            'correo' => $validatedData['correo_contacto'],
            'cliente_id' => $validatedData['cliente_id'],
        ]);

        return redirect()->back()->with('success', 'Contacto creado exitosamente.');
    }
}
