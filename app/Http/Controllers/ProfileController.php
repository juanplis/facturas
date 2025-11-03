<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
use App\Models\Estatus;

class ProfileController extends Controller
{
  /* 
    public function index()
    {
        $profile = Profile::all();
        return view('profile.index', compact('profile'));
    }
   */
   public function index31102025(Request $request)
    {
        // Obtener el término de búsqueda
        $search = $request->input('search');

        // Filtrar las tasas según el término de búsqueda
        $profile = Profile::when($search, function($query) use ($search) {
            return $query->where('name', 'LIKE', "%{$search}%");
        })->get(); // Puedes cambiar get() por paginate(10) si deseas paginación

        return view('profile.index', compact('profile'));
    }
  
  public function index(Request $request)
    {
        // Obtener el término de búsqueda
        $search = $request->input('search');

        // Filtrar los perfiles según el término de búsqueda
        $profile = Profile::with('estatus') // Cargar la relación 'estatus'
            ->when($search, function($query) use ($search) {
                return $query->where('name', 'LIKE', "%{$search}%");
            })->get(); // Cambia get() por paginate(10) si deseas paginación

        return view('profile.index', compact('profile'));
    }
    public function create()
    {
        return view('profile.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);
        Profile::create($request->all());
        return redirect()->route('profile.index');
    }

    public function edit(Profile $profile)
    {
    //    return view('profile.edit', compact('profile'));
         $estatus = Estatus::all(); // Obtener todos los estatus
         return view('profile.edit', compact('profile', 'estatus'));
 
    }
  
    public function edit3110202525(Profile $profile)
    {
      $estatus = Estatus::all(); // Obtener todos los estatus
      $estado = $profile->estatus == 1 ? 'Activo' : 'Inactivo'; // Determinar el estado
      return view('profile.edit', compact('profile', 'estatus', 'estado'));
    }

    public function update(Request $request, Profile $profile)
    {
        $request->validate(['name' => 'required|string|max:255']);
        $profile->update($request->all());
        return redirect()->route('profile.index');
    }

  
    public function update31102025(Request $request, Profile $profile)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'estatus_id' => 'required|exists:estatus,id', // Validar que el estatus exista
        ]);

        $profile->update($request->all());
        return redirect()->route('profile.index');
    }
  
    public function destroy(Profile $profile)
    {
        $profile->delete();
        return redirect()->route('profile.index');
    }
}
