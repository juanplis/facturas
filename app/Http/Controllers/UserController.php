<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Profile; // Asegúrate de incluir el modelo Profile

class UserController extends Controller
{
    // Listar usuarios
/*    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }
   */
   public function index2222(Request $request)
    {
        // Obtener el término de búsqueda
        $search = $request->input('search');

        // Filtrar las tasas según el término de búsqueda
        $users = User::when($search, function($query) use ($search) {
            return $query->where('name', 'LIKE', "%{$search}%")
                         ->orWhere('email', 'LIKE', "%{$search}%");
        })->get(); // Puedes cambiar get() por paginate(10) si deseas paginación
       // $perfil_name = Profile::where('id', $users->perfil_id)->first();

 //    dd($users);

        // Obtener el nombre del perfil
        $perfil = Profile::where('id', $users->perfil_id)->first();

     
        if ($perfil) {
            // Almacenar el nombre del perfil en la sesión
        $perfil= $perfil->name;
        }
     
  // Auten
     
     
        return view('users.index', compact('users','perfil'));
    }
  public function index(Request $request)
{
    // Obtener el término de búsqueda
    $search = $request->input('search');

    // Filtrar las tasas según el término de búsqueda y cargar el perfil
    $users = User::with('perfil') // Asegúrate de tener esta relación definida en el modelo User
        ->when($search, function($query) use ($search) {
            return $query->where('name', 'LIKE', "%{$search}%")
                         ->orWhere('email', 'LIKE', "%{$search}%");
        })
        ->get(); // Puedes cambiar get() por paginate(10) si deseas paginación

    return view('users.index', compact('users'));
}

    // Mostrar formulario para crear un nuevo usuario
    public function create()
    {   /*
        return view('users.create');*/
      
      // Obtener todos los perfiles
        $perfiles = Profile::all(['id', 'name', 'updated_at', 'created_at']);
        
        return view('users.create', compact('perfiles'));
    }

    // Almacenar un nuevo usuario
    public function store1(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('users.index')->with('success', 'Usuario creado exitosamente.');
    }
    // Almacenar un nuevo usuario
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'perfil_id' => 'required|exists:profile,id', // Asegúrate de que el perfil exista
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'perfil_id' => $request->perfil_id, // Almacenar el perfil_id
        ]);

        return redirect()->route('users.index')->with('success', 'Usuario creado exitosamente.');
    }

    // Mostrar un usuario específico
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    // Mostrar formulario para editar un usuario
    public function edit(User $user)
    {
      /*  return view('users.edit', compact('user'));*/
      
        $perfiles = Profile::all(['id', 'name']);
        
        // Pasar tanto el usuario como los perfiles a la vista
        return view('users.edit', compact('user', 'perfiles'));
      
    }

    // Actualizar un usuario existente
    public function update1(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? bcrypt($request->password) : $user->password,
        ]);

        return redirect()->route('users.index')->with('success', 'Usuario actualizado exitosamente.');
    }
    // Actualizar un usuario existente
    public function update2(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6',
            'perfil_id' => 'required|exists:profiles,id', // Asegúrate de que el perfil exista
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? bcrypt($request->password) : $user->password,
            'perfil_id' => $request->perfil_id, // Almacenar el perfil_id
        ]);

        return redirect()->route('users.index')->with('success', 'Usuario actualizado exitosamente.');
    }
    // Actualizar un usuario existente
    public function update3(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6',
            'perfil_id' => 'nullable|exists:profiles,id', // Permitir que sea nulo
        ]);

        // Verificar si el perfil_id tiene un valor y si es igual a 1
        if ($request->perfil_id && $request->perfil_id == 1) {
            $user->perfil_id = $request->perfil_id; // Asignar el valor de perfil_id
        }

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? bcrypt($request->password) : $user->password,
            // No actualizar perfil_id aquí, ya que se maneja arriba
        ]);

        $user->save(); // Guardar los cambios

        return redirect()->route('users.index')->with('success', 'Usuario actualizado exitosamente.');
    }
    // Actualizar un usuario existente
    public function update4(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6',
            'perfil_id' => 'nullable|exists:profile,id', // Permitir que sea nulo
        ]);
/*
        // Asignar el valor de perfil_id si está presente y es igual a 1
        if ($request->perfil_id && $request->perfil_id == 1) {
            $user->perfil_id = $request->perfil_id; // Asignar el valor de perfil_id
        }
*/
        // Actualizar los campos del usuario
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password ? bcrypt($request->password) : $user->password,
            'perfil_id' => $request->perfil_id, // Incluir perfil_id aquí
        ]);

        return redirect()->route('users.index')->with('success', 'Usuario actualizado exitosamente.');
    }
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:6',
            'perfil_id' => 'required|exists:profile,id', // Asegúrate de que el perfil existe
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }
        $user->perfil_id = $request->perfil_id; // Actualiza el perfil_id

        $user->save(); // Guarda los cambios

        return redirect()->route('users.index')->with('success', 'Usuario actualizado exitosamente.');
    }

    // Eliminar un usuario
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'Usuario eliminado exitosamente.');
    }
}
