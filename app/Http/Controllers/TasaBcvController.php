<?php
namespace App\Http\Controllers;

use App\Models\PorcentajeInventario;
use App\Models\TasaBcv;
use Illuminate\Http\Request;

class TasaBcvController extends Controller
{
 /*
  public function index()
    {
        $tasa_bcvs = TasaBcv::all();
        return view('tasa_bcv.index', compact('tasa_bcvs'));
    }
*/
   public function index(Request $request)
    {
        // Obtener el término de búsqueda
        $search = $request->input('search');

        // Filtrar las tasas según el término de búsqueda
        $tasa_bcvs = TasaBcv::when($search, function($query) use ($search) {
            return $query->where('fecha_bcv', 'LIKE', "%{$search}%")
                         ->orWhere('monto_bcv', 'LIKE', "%{$search}%")
                         ->orWhere('monto_bcv_euro', 'LIKE', "%{$search}%")
                         ->orWhere('intervenciones', 'LIKE', "%{$search}%");
        })->get(); // Puedes cambiar get() por paginate(10) si deseas paginación

        $ultimo_porcentaje = PorcentajeInventario::latest()->first();
    // ^^^ Asumiendo que usaste la solución de 'latest()->first()'

        return view('tasa_bcv.index', compact('tasa_bcvs', 'ultimo_porcentaje'));
    }
    public function create()
    {
        return view('tasa_bcv.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'fecha_bcv' => 'required|date',
            'monto_bcv' => 'required|numeric',
            'monto_bcv_euro' => 'required|numeric',
            'intervenciones' => 'required|string|max:30',
        ]);

        TasaBcv::create($request->all());
        return redirect()->route('tasa_bcv.index')->with('success', 'Registro creado exitosamente.');
    }

    public function show(TasaBcv $tasa_bcv)
    {
        return view('tasa_bcv.show', compact('tasa_bcv'));
    }

    public function edit(TasaBcv $tasa_bcv)
    {
        return view('tasa_bcv.edit', compact('tasa_bcv'));
    }
    public function update(Request $request, TasaBcv $tasa_bcv)
    {
        $request->validate([
            'fecha_bcv' => 'required|date',
            'monto_bcv' => 'required|numeric',
            'monto_bcv_euro' => 'required|numeric',
            'intervenciones' => 'required|string|max:30',
        ]);

        $tasa_bcv->update($request->all());
        return redirect()->route('tasa_bcv.index')->with('success', 'Registro actualizado exitosamente.');
    }

    public function destroy(TasaBcv $tasa_bcv)
    {
        $tasa_bcv->delete();
        return redirect()->route('tasa_bcv.index')->with('success', 'Registro eliminado exitosamente.');
    }
}
