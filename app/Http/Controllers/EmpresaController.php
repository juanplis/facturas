<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

  use App\Models\Empresa;

class EmpresaController extends Controller
{

public function index2() {
    $empresas = Empresa::paginate(10);
    return view('empresas.index', compact('empresas'));
}
  
public function index(Request $request)
{
    // Obtener el término de búsqueda
    $search = $request->input('search');

    // Filtrar las empresas según el término de búsqueda y paginar los resultados
    $empresas = Empresa::when($search, function($query) use ($search) {
        return $query->where('rif', 'LIKE', "%{$search}%")
                     ->orWhere('razon_social', 'LIKE', "%{$search}%")
                     ->orWhere('correo_empresa', 'LIKE', "%{$search}%");
    })->paginate(10); // Cambia '10' por el número de elementos por página que desees

    return view('empresas.index', compact('empresas'));
  
}
  
/*
public function store(Request $request) {
    $request->validate([
        'razon_social' => 'required|string|max:100',
        'rif' => 'required|string|max:20|unique:empresas',
        'telefono' => 'required|string|max:15',
        'fecha_registro' => 'required|date',
    ]);

    Empresa::create($request->all());
    return redirect()->route('empresas.index')->with('success', 'Empresa creada!');
}
*/
// Implementar edit(), update(), destroy() y show() de forma similar

/**
     * Muestra los detalles de una empresa específica
     */

      public function create()
    {
        return view('empresas.create');
    }

 public function store(Request $request)
    {
        $request->validate([
            'razon_social' => 'required',
            'rif' => 'required',
            'correo_empresa' => 'required',
            'telefono' => 'required',
            'estatus' => 'required',
            'fecha_registro' => 'required|date',
        ]);

        Empresa::create($request->all());

        return redirect()->route('empresas.index')
            ->with('success', 'Empresa creada exitosamente.');
    }

    public function show($id)
    {
        $empresa = Empresa::findOrFail($id);
        return view('empresas.show', compact('empresa'));
    }

    /**
     * Muestra el formulario para editar una empresa
     */
    public function edit($id)
    {
        $empresa = Empresa::findOrFail($id);
        return view('empresas.edit', compact('empresa'));
    }

    /**
     * Actualiza una empresa en la base de datos
     */
    public function update(Request $request, $id)
    {
        $empresa = Empresa::findOrFail($id);

        $request->validate([
            'razon_social' => 'required|string|max:100',
            'rif' => 'required|string|max:20|unique:empresa,rif,'.$empresa->id,
            'telefono' => 'required|string|max:15',
                      'correo_empresa' => 'required|string|max:100',
            'fecha_registro' => 'required|date',
        ]);

        $empresa->update($request->all());

        return redirect()->route('empresas.index')
            ->with('success', '¡Empresa actualizada correctamente!');
    }

    /**
     * Elimina una empresa de la base de datos
     */
    public function destroy($id)
    {
        $empresa = Empresa::findOrFail($id);
        $empresa->delete();

        return redirect()->route('empresas.index')
            ->with('success', '¡Empresa eliminada correctamente!');
    }

}
