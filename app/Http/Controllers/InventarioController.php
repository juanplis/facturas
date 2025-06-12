<?php

namespace App\Http\Controllers;

use App\Models\Inventario;
use Illuminate\Http\Request;
use App\Models\Producto; // Asegúrate de que tu modelo Producto esté correctamente mapeado a la tabla 'inventario'

class InventarioController extends Controller
{
    public function index(Request $request)
    {

       // Inicia la consulta base para el modelo 'Producto' (que usa la tabla 'inventario')
        $query = Inventario::query();

        // Implementa la funcionalidad de búsqueda
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where('codigo', 'like', '%' . $searchTerm . '%')
                  ->orWhere('descripcion', 'like', '%' . $searchTerm . '%')
                  ->orWhere('concepto_general', 'like', '%' . $searchTerm . '%');
            // Puedes añadir más columnas para buscar aquí si lo necesitas
        }

        // Aplica la paginación
        // paginate(10) significa 10 elementos por página. Puedes ajustar este número.
        $inventarios = $query->paginate(10);

        // Pasa los resultados paginados y el término de búsqueda a la vista
        return view('inventario.index', compact('inventarios'));
    }
}
