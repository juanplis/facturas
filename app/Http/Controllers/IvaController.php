<?php
namespace App\Http\Controllers;

use App\Models\Iva;
use Illuminate\Http\Request;

class IvaController extends Controller
{
  /*
    public function index()
    {
        $iva = Iva::all();
        return view('iva.index', compact('iva'));
    }
    
    */
   public function index(Request $request)
    {
        // Obtener el término de búsqueda
        $search = $request->input('search');

        // Filtrar las tasas según el término de búsqueda
        $iva = Iva::when($search, function($query) use ($search) {
            return $query->where('monto_iva', 'LIKE', "%{$search}%")
                        
                         ->orWhere('fecha', 'LIKE', "%{$search}%");

        })->get(); // Puedes cambiar get() por paginate(1fecha0) si deseas paginación

        return view('iva.index', compact('iva'));
    }
    public function create()
    {
        return view('iva.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'monto_iva' => 'required|numeric',
            'estatus' => 'required|integer',
        ]);

        Iva::create($request->all());
        return redirect()->route('iva.index')->with('success', 'IVA creado correctamente.');
    }

    public function show(Iva $iva)
    {
        return view('iva.show', compact('iva'));
    }

    public function edit(Iva $iva)
    {
        return view('iva.edit', compact('iva'));
    }

    public function update(Request $request, Iva $iva)
    {
        $request->validate([
            'monto_iva' => 'required|numeric',
            'fecha' => 'required|date',           
            'estatus' => 'required|integer',
        ]);

        $iva->update($request->all());
        return redirect()->route('iva.index')->with('success', 'IVA actualizado correctamente.');
    }

    public function destroy(Iva $iva)
    {
        $iva->delete();
        return redirect()->route('iva.index')->with('success', 'IVA eliminado correctamente.');
    }
}
