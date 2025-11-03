<?php

namespace App\Http\Controllers;

use App\Models\Inventario;
use Illuminate\Http\Request;

class InventarioController extends Controller
{
   
  public function actualizarPrecios(Request $request)
{
    $precios = $request->input('precios');

    foreach ($precios as $precio) {
        $inventario = Inventario::find($precio['id']);
        if ($inventario) {
            $inventario->precio_unitario = $precio['nuevoPrecio'];
            $inventario->save();
        }
    }

    return response()->json(['success' => true]);
}

   
    public function index(Request $request)
    {
        // Inicia la consulta base para el modelo 'Inventario'
        $query = Inventario::query();

        // Implementa la funcionalidad de búsqueda
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where('codigo', 'like', '%' . $searchTerm . '%')
                  ->orWhere('descripcion', 'like', '%' . $searchTerm . '%')
                  ->orWhere('concepto_general', 'like', '%' . $searchTerm . '%');
        }

        // Aplica la paginación (10 elementos por página)
      $inventarios = $query->orderBy('id', 'DESC')->paginate(10); 

       // $inventarios = $query->paginate(10);

        // Pasa los resultados paginados a la vista
        return view('inventario.index', compact('inventarios'));
    }

   
    public function create()
    {
        return view('inventario.create');
    }


 public function store(Request $request)
{
    // 1. Valida los datos de entrada
    // El resultado de validate() SÍ incluye todos los campos que necesitan ser insertados.
    $validatedData = $request->validate([
        'codigo' => 'required|string|max:255|unique:inventario,codigo',
        'descripcion' => 'required|string|max:255',
        'precio_unitario' => 'nullable|numeric',
        // Si descomentas estos en el formulario, debes descomentarlos aquí:
        // 'precio_tu_cocina' => 'nullable|numeric',
        // 'costo' => 'nullable|numeric',
        'concepto_general' => 'nullable|string|max:255',
        'version' => 'nullable|string|max:255',
        'dimensiones' => 'nullable|string|max:255',
        'detalles' => 'nullable|string',
    ]);

    // 2. Crea un nuevo producto SÓLO con los datos validados ($validatedData)
    // Esto previene el error 1364/1064 al excluir el _token y otros datos no validados.
    // **Importante:** Asegúrate de que tu modelo 'Inventario' tenga la propiedad $fillable definida.
    Inventario::create($validatedData);

    // 3. Redirige de vuelta al índice con un mensaje de éxito
    return redirect()->route('inventario.index')->with('success', 'Producto creado exitosamente.');
}
  
  
  public function edit(Inventario $inventario)
{
    return view('inventario.edit', compact('inventario'));
}

    
  
 public function update(Request $request, $id)
{
    // 1. Validar los datos recibidos
    $request->validate([
        'codigo' => 'required|string|max:255|unique:inventario,codigo,' . $id, // Permitir el mismo código
        'descripcion' => 'required|string|max:255',
        'precio_unitario' => 'nullable|numeric',
        'concepto_general' => 'nullable|string|max:255',
        'version' => 'nullable|string|max:255',
        'dimensiones' => 'nullable|string|max:255',
        'detalles' => 'nullable|string',
    ]);

    // 2. Encontrar el inventario existente
    $inventario = Inventario::findOrFail($id);

    // 3. Actualizar los datos del inventario
    $inventario->update([
        'codigo' => $request->codigo,
        'descripcion' => $request->descripcion,
        'precio_unitario' => $request->precio_unitario ?? $inventario->precio_unitario,
        'concepto_general' => $request->concepto_general ?: null,
        'version' => $request->version ?: null,
        'dimensiones' => $request->dimensiones ?: null,
        'detalles' => $request->detalles ?: null,
    ]);

   

    return redirect()->route('inventario.index')->with('success', 'Producto actualizado exitosamente.');
}

  
    /**
     * Elimina un producto de la base de datos.
     *
     * @param  \App\Models\Inventario  $inventario
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Inventario $inventario)
    {
        // Elimina el producto
        $inventario->delete();

        // Redirige de vuelta al índice con un mensaje de éxito
        return redirect()->route('inventario.index')->with('success', 'Producto eliminado exitosamente.');
    }
  
  
   public function buscarProductos(Request $request)
    {
        $query = $request->get('q');
        $productos = Inventario::where('descripcion', 'LIKE', "%{$query}%")
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
        $producto = Inventario::find($id);
        if ($producto) {
            return response()->json($producto);
        }
        return response()->json(['error' => 'Producto no encontrado'], 404);
    }

  
  
}
