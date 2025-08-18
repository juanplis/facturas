<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
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
        /* Estilos para mensajes de éxito/error */
        .alert-success {
            background-color: #d4edda;
            border-color: #c3e6cb;
            color: #155724;
            padding: 1rem;
            margin-bottom: 1rem;
            border-radius: 0.25rem;
        }
        .alert-danger {
            background-color: #f8d7da;
            border-color: #f5c6cb;
            color: #721c24;
            padding: 1rem;
            margin-bottom: 1rem;
            border-radius: 0.25rem;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1>Inventario</h1>

        {{-- Mensajes de éxito --}}
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        {{-- Formulario de búsqueda --}}
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

        {{-- Botón para crear nuevo --}}
        <div class="mb-3">
            <a href="{{ route('inventario.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Crear Nuevo Producto
            </a>
        </div>

        <div>
            <h1>Ajuste de precio</h1>
            <input type="text" placeholder="Porcentaje de aumento" name="aumento" id="aumento">
            <button onclick="actualizarPrecios()">Actualizar</button>
        </div>
        <br>

        {{-- Tabla de inventario --}}
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="thead-light">
                    <tr>
                        <th>Código</th>
                        <th>Descripción</th>
                        <th>Precio Unitario</th>
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
                        <td class="precio-unitario">{{ $inventario->precio_unitario }}</td>
                        <td>{{ $inventario->costo }}</td>
                        <td>{{ $inventario->concepto_general }}</td>
                        <td>{{ $inventario->version }}</td>
                        <td>{{ $inventario->dimensiones }}</td>
                        <td>{{ $inventario->detalles }}</td>
                        <td>
                            {{-- Botón de Editar --}}
                            <a href="{{ route('inventario.edit', $inventario->id) }}" class="btn btn-primary btn-sm">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                            {{-- Botón de Eliminar (con formulario para método DELETE) --}}
                            <form action="{{ route('inventario.destroy', $inventario->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de que quieres eliminar este producto?');">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center">No hay productos en el inventario.</td> {{-- Colspan ajustado --}}
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Paginación --}}
        <div class="d-flex justify-content-center mt-4">
            {{ $inventarios->appends(request()->except('page'))->links('pagination::bootstrap-4') }}
        </div>

    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        function actualizarPrecios() {
            // Obtener el porcentaje de aumento
            const porcentajeAumento = parseFloat(document.getElementById('aumento').value);

            // Verificar que el porcentaje sea un número válido
            if (isNaN(porcentajeAumento)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Por favor, introduce un monto.',
                });
                return;
            }

            // Obtener todas las celdas de precios unitarios
            const preciosUnitarios = document.querySelectorAll('.precio-unitario');

            // Calcular y actualizar el precio de cada producto
            preciosUnitarios.forEach(precio => {
                let precioActual = parseFloat(precio.textContent);
                let nuevoPrecio = precioActual + (precioActual * (porcentajeAumento / 100));
                precio.textContent = nuevoPrecio.toFixed(2); // Formatear a 2 decimales
            });

            // Mostrar SweetAlert de confirmación
            Swal.fire({
                icon: 'success',
                title: 'Éxito',
                text: 'Los precios han sido actualizados correctamente.',
            });

            // Limpiar el campo de entrada
            document.getElementById('aumento').value = '';
        }
    </script>
</body>
</html>
