<?php

namespace App\Http\Controllers;

use App\Models\Inventario; // Asumo que este es tu modelo principal para la tabla 'inventario'
use Illuminate\Http\Request;
use Illuminate\Validation\Rule; // Necesario para la validación 'unique' si la usas

class InventarioController extends Controller
{
    /**
     * Muestra una lista paginada de productos de inventario con funcionalidad de búsqueda.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Inicia la consulta base para el modelo 'Inventario'
        $query = Inventario::query();

        // Implementa la funcionalidad de búsqueda por código, descripción o concepto.
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('codigo', 'like', '%' . $searchTerm . '%')
                  ->orWhere('descripcion', 'like', '%' . $searchTerm . '%')
                  ->orWhere('concepto_general', 'like', '%' . $searchTerm . '%');
            });
        }

        // Aplica la paginación: 10 elementos por página.
        $inventarios = $query->paginate(10);

        // Pasa los resultados paginados a la vista.
        return view('inventario.index', compact('inventarios'));
    }

    /**
     * Muestra el formulario para editar un producto de inventario específico.
     *
     * @param  \App\Models\Inventario  $inventario El modelo Inventario inyectado automáticamente.
     * @return \Illuminate\View\View
     */
    public function edit(Inventario $inventario)
    {
        // Pasa el objeto $inventario a la vista 'inventario.edit'.
        return view('inventario.edit', compact('inventario'));
    }

    /**
     * Actualiza el producto de inventario especificado en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request  La solicitud HTTP con los datos del formulario.
     * @param  \App\Models\Inventario  $inventario El modelo Inventario a actualizar.
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Inventario $inventario)
    {
        // Define las reglas de validación para los campos del formulario.
        // Asegúrate de que 'codigo' sea único, pero ignorando el registro actual.
        $request->validate([
                 'codigo' => [
                'required',
                'string',
                'max:255',
                Rule::unique('inventario', 'codigo')->ignore($inventario->id),
            ],
            'descripcion' => 'required|string|max:255',
            'precio_unitario' => 'required|numeric|min:0',
            'precio_cocina' => 'required|numeric|min:0',
            'costo' => 'required|numeric|min:0',
            'concepto_general' => 'nullable|string|max:255',
            'version' => 'nullable|string|max:255',
            'dimensiones' => 'nullable|string|max:255',
            'detalles' => 'nullable|string',
        ]);

        // Actualiza el producto de inventario con los datos validados de la solicitud.
        $inventario->update($request->all());

        // Redirige al usuario de vuelta a la página principal del inventario con un mensaje de éxito.
        return redirect()->route('inventario.index')->with('success', 'Producto de inventario actualizado exitosamente.');
    }
}
