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
    <title>Clientes</title>
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
        <h1>Lista de Clientes</h1>
        <a href="{{ route('user.crear') }}" class="btn btn-primary mb-3">Crear Cliente</a>
        <table class="table table-bordered">
            <thead class="thead-light">
                <tr>
                    <th>Nombre</th>
                    <th>RIF</th>
                    <th>Dirección</th>
                    <th>Teléfono</th>
                    <th>Correo</th>
                    <th>Acciones</th> <!-- Columna para acciones -->
                </tr>
            </thead>
            <tbody>
                @foreach($clientes as $cliente)
                <tr>
                    <td>{{ $cliente->nombre }}</td>
                    <td>{{ $cliente->rif }}</td>
                    <td>{{ $cliente->direccion }}</td>
                    <td>{{ $cliente->telefono }}</td>
                    <td>{{ $cliente->correo }}</td>
                    <td>
                        <div class="btn-group" role="group" aria-label="Acciones">
                            <a href="{{ route('user.editar', $cliente->id) }}" class="btn btn-primary">
                                <i class="fas fa-pencil-alt"></i> <!-- Icono de lápiz -->
                            </a>
                            <form action="{{ route('user.elimina', $cliente->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de que quieres eliminar este cliente?');">
                                    <i class="fas fa-trash-alt"></i> <!-- Icono de papelera -->
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
