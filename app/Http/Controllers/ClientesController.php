<?php

namespace App\Http\Controllers;

use App\Models\Clientes;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ClientesController extends Controller
{
    public function index()
    {
        $clientes = Clientes::all(); // Obtener todos los clientes
        return view('clientes.index', compact('clientes')); // Pasar datos a la vista
    }
}
