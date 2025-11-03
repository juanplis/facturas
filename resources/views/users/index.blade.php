<!DOCTYPE html>
<html lang="es">
<head>
    <!-- Enlace a Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Enlace a Select2 CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <!-- Enlace a Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    @include('menu')
    <title>Usuarios</title>
    <style>
        /* Estilo para filas alternas */
        tbody tr:nth-child(odd) {
            background-color: #f8f9fa; /* Color gris claro */
        }
        tbody tr:nth-child(even) {
            background-color: #ffffff; /* Color blanco */
        }
    </style>
</head>
<body>
    <div class="container mt-5">
    <form action="{{ route('users.index') }}" method="GET" class="mb-3">
    <h3>Lista de Usuarios</h3>
    <a href="{{ route('users.create') }}" class="btn btn-primary">Crear Usuario</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
      
        <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Buscar por Nombre o email..." value="{{ request('search') }}">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit">Buscar</button>
                </div>
            </div>
       
    <table class="table">
        <thead>
            <tr>
                <th>N°</th>
                <th>Nombre</th>
                <th>Perfil</th>
                <th>Email</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
         		   <td>{{  $user->perfil->name ?? 'Sin perfil' }}</td> <!-- Usar el nombre del perfil -->
                    <td>{{ $user->email }}</td>
                    <td>
                        <a href="{{ route('users.edit', $user) }}"class="btn btn-primary">
                           <i class="fas fa-pencil-alt"></i>
                        </a>
                        <form action="{{ route('users.destroy', $user) }}" method="POST" style="display:inline;" class="delete-form">
                            @csrf
                            @method('DELETE')
                          
                             <button type="submit" class="btn btn-danger delete-button" data-id="{{ $user }}">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
  </form>
</div>
</body>
</html>
