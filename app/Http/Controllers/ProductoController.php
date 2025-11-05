<?php

// app/Http/Controllers/ProductoController.php

namespace App\Http\Controllers;

use App\Models\InventarioController; // Asegúrate de tener tu modelo de producto
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function buscarProductos(Request $request)
    {
        $query = $request->get('q');
        $productos = Producto::where('descripcion', 'LIKE', "%{$query}%")
            ->orWhere('codigo', 'LIKE', "%{$query}%")
            ->paginate(10); // Paginación para mejorar el rendimiento

        return response()->json([
            'items' => $productos->items(),
            'pagination' => [
                'has_more' => $productos->hasMorePages(),
            ],
        ]);
    }

    public function obtenerProducto($id)
    {
        $producto = Producto::find($id);
        if ($producto) {
            return response()->json($producto);
        }
        return response()->json(['error' => 'Producto no encontrado'], 404);
    }
}


?>
