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
    <title>Perfiles</title>
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
    <form action="{{ route('profile.index') }}" method="GET" class="mb-3">
    <h3>Lista de Perfiles</h3>
    <a href="{{ route('profile.create') }}" class="btn btn-primary">Crear Nuevo Perfil</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
      
        <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Buscar por Nombre ..." value="{{ request('search') }}">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit">Buscar</button>
                </div>
            </div>
       
    <table class="table">
        <thead>
            <tr>
                <th>N°</th>
                <th>Nombre Perfil</th>
                <th>Estatus</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($profile as $profiles)
                <tr>
                    <td>{{ $profiles->id }}</td>
                    <td>{{ $profiles->name }}</td>
                    <td>{{ $profiles->estatus }}</td> 
         		    <td>{{  $profiles->estatus->nombre ?? 'Sin estatus' }}</td> <!-- Usar el nombre del perfil -->

                    <td>
                        <a href="{{ route('profile.edit', $profiles) }}"class="btn btn-primary">
                           <i class="fas fa-pencil-alt"></i>
                        </a>
                        <form action="{{ route('profile.destroy', $profile) }}" method="POST" style="display:inline;" class="delete-form">
                            @csrf
                            @method('DELETE')
                          
                             <button type="submit" class="btn btn-danger delete-button" data-id="{{ $profile }}">
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
      
      
</body>
</html>
