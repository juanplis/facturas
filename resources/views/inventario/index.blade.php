<!DOCTYPE html>
<html lang="es">
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    @include('menu')
    <title>Inventario</title>
    <style>
        /* Estilo para filas alternas */
        tbody tr:nth-child(odd) {
            background-color: #f8f9fa; /* Color gris claro */
        }
        tbody tr:nth-child(even) {
            background-color: #ffffff; /* Color blanco */
        }
        /* Estilo para el formulario de búsqueda */
        .search-form {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1>Inventario</h1>

        {{-- Mensajes de sesión (por ejemplo, para éxito en la actualización) --}}
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('inventario.index') }}" method="GET" class="form-inline search-form">
            <div class="input-group w-100">
                <input type="text" name="search" class="form-control" placeholder="Buscar por código, descripción o concepto..." value="{{ request('search') }}">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit">
                        <i class="fas fa-search"></i> Buscar
                    </button>
                    @if(request()->filled('search'))
                        <a href="{{ route('inventario.index') }}" class="btn btn-outline-danger ml-2">
                            <i class="fas fa-times"></i> Limpiar
                        </a>
                    @endif
                </div>
            </div>
        </form>

        <table class="table table-bordered">
            <thead class="thead-light">
                <tr>
                    <th>Código</th>
                    <th>Descripción</th>
                    <th>Precio Steel</th>
                    <th>Precio Tu Cocina</th>
                    <th>Costo</th>
                    <th>Concepto General</th>
                    <th>Versión</th>
                    <th>Dimensiones</th>
                    <th>Detalles</th>
                    <th>Acciones</th> {{-- Nueva columna para acciones --}}
                </tr>
            </thead>
            <tbody>
                @forelse ($inventarios as $inventario)
                <tr>
                    <td>{{ $inventario->codigo }}</td>
                    <td>{{ $inventario->descripcion }}</td>
                    <td>{{ $inventario->precio_unitario }}</td>
                    <td>{{ $inventario->precio_cocina }}</td>
                    <td>{{ $inventario->costo }}</td>
                    <td>{{ $inventario->concepto_general }}</td>
                    <td>{{ $inventario->version }}</td>
                    <td>{{ $inventario->dimensiones }}</td>
                    <td>{{ $inventario->detalles }}</td>
                    <td>
                        {{-- Botón para editar --}}
                        <a href="{{ route('inventario.edit', $inventario->id) }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-edit"></i> Editar
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="10" class="text-center">No hay productos en el inventario.</td> {{-- Actualizado a colspan 10 --}}
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="d-flex justify-content-center mt-4">
            {{ $inventarios->appends(request()->except('page'))->links('pagination::bootstrap-4') }}
        </div>

    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
</body>
</html>