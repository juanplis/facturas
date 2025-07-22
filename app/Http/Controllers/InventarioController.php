<?php

namespace App\Http\Controllers;

use App\Models\Inventario;
use Illuminate\Http\Request;

class InventarioController extends Controller
{
    /**
     * Muestra una lista de productos de inventario.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
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
        $inventarios = $query->paginate(10);

        // Pasa los resultados paginados a la vista
        return view('inventario.index', compact('inventarios'));
    }

    /**
     * Muestra el formulario para crear un nuevo producto.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('inventario.create');
    }

    /**
     * Almacena un nuevo producto en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Valida los datos de entrada
        $request->validate([
            'codigo' => 'required|string|max:255|unique:inventario,codigo',
            'descripcion' => 'required|string|max:255',
            'precio_steel' => 'nullable|numeric',
            'precio_tu_cocina' => 'nullable|numeric',
            'costo' => 'nullable|numeric',
            'concepto_general' => 'nullable|string|max:255',
            'version' => 'nullable|string|max:255',
            'dimensiones' => 'nullable|string|max:255',
            'detalles' => 'nullable|string',
        ]);

        // Crea un nuevo producto con los datos validados
        Inventario::create($request->all());

        // Redirige de vuelta al índice con un mensaje de éxito
        return redirect()->route('inventario.index')->with('success', 'Producto creado exitosamente.');
    }

    /**
     * Muestra el formulario para editar un producto existente.
     *
     * @param  \App\Models\Inventario  $inventario
     * @return \Illuminate\View\View
     */
    public function edit(Inventario $inventario)
    {
        return view('inventario.edit', compact('inventario'));
    }

    /**
     * Actualiza un producto existente en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Inventario  $inventario
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Inventario $inventario)
    {
        // Valida los datos de entrada
        $request->validate([
            'codigo' => 'required|string|max:255|unique:inventario,codigo,' . $inventario->id,
            'descripcion' => 'required|string|max:255',
            'precio_steel' => 'nullable|numeric',
            'precio_tu_cocina' => 'nullable|numeric',
            'costo' => 'nullable|numeric',
            'concepto_general' => 'nullable|string|max:255',
            'version' => 'nullable|string|max:255',
            'dimensiones' => 'nullable|string|max:255',
            'detalles' => 'nullable|string',
        ]);

        // Actualiza el producto con los datos validados
        $inventario->update($request->all());

        // Redirige de vuelta al índice con un mensaje de éxito
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
}
