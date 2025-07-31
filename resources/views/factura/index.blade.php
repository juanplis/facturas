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
    <title>Lista de Presupuestos</title>
    <style>
        /* Estilo para filas alternas */
        tbody tr:nth-child(odd) {
            background-color: #f8f9fa; /* Color gris claro */
        }
        tbody tr:nth-child(even) {
            background-color: #ffffff; /* Color blanco */
        }

        /* Indicadores de estado */
        .estatus-badge {
            padding: 0.25em 0.6em;
            border-radius: 10px;
            font-size: 0.85em;
        }
        .estatus-activo {
            background-color: #d4edda;
            color: #155724;
        }
        .estatus-inactivo {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1>Lista de Presupuestos</h1>
     <a href="{{ route('buscar', ['id' => 1]) }}" class="btn btn-primary mb-3">Crear Presupuesto (STELL)</a>
    <a href="{{ route('buscar', ['id' => 2]) }}" class="btn btn-primary mb-3">Crear Presupuesto (TuCocina)</a>

        <table class="table table-bordered">
            <thead class="thead-light">
                <tr>
                    <th>N° Presupuesto</th>
                    <th>Cliente ID</th>
                    <th>Empresa</th>
                    <th>Fecha</th>
                    <th>Subtotal</th>
                    <th>IVA</th>
                    <th>Total</th>
                    <th>Condiciones de Pago</th>
                    <th>Tiempo Entrega</th>
                    <th>Validez</th>
                    <th>Estatus</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($presupuestos as $presupuesto)
                <tr>
                    <td>{{ $presupuesto->id }}</td>
                    <td>{{ $presupuesto->cliente_id }}</td>
                    <td>{{ $presupuesto->empresa_id }}</td>
                    <td>{{ $presupuesto->fecha }}</td>
                    <td>{{ number_format($presupuesto->subtotal, 2, ',', '.') }} </td>
                    <td>{{ number_format($presupuesto->iva, 2, ',', '.') }} </td>
                    <td>{{ number_format($presupuesto->total, 2, ',', '.') }} </td>
                    <td>{{ $presupuesto->condiciones_pago }}</td>
                    <td>{{ $presupuesto->tiempo_entrega }}</td>
                    <td>{{ $presupuesto->validez }}</td>
<td>
    @if($presupuesto->estado) {{-- ¡Ahora es un objeto! --}}
        <span class="estatus-badge estatus-{{ $presupuesto->estado->estatus ? 'activo' : 'inactivo' }}">
            {{ $presupuesto->estado->nombre }} {{-- Muestra el nombre --}}
        </span>
    @else
        <span class="text-muted">Estado no disponible</span>
    @endif
</td>
<td>
                        <a href="{{ route('factura.ver', $presupuesto->id) }}" class="btn btn-info">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('factura.edita', $presupuesto->id) }}" class="btn btn-primary">
                            <i class="fas fa-pencil-alt"></i>
                        </a>
                        <form action="{{ route('factura.elimina', $presupuesto->id) }}" method="POST" class="delete-form" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger delete-button" data-id="{{ $presupuesto->id }}">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                        <a href="{{ route('presupuestos.pdf', $presupuesto->id) }}" class="btn btn-success">
                            <i class="fas fa-file-pdf"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Incluir el script de SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Manejar el evento de envío del formulario de eliminación
            const deleteForms = document.querySelectorAll('.delete-form');

            deleteForms.forEach(form => {
                form.addEventListener('submit', function(event) {
                    event.preventDefault(); // Prevenir el envío del formulario

                    const formData = new FormData(form);
                    const id = form.querySelector('.delete-button').getAttribute('data-id');

                    Swal.fire({
                        title: '¿Estás seguro?',
                        text: "¡No podrás revertir esto!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Sí, eliminarlo!',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit(); // Enviar el formulario si el usuario confirma
                        }
                    });
                });
            });

            // Mostrar mensajes de éxito o error al cargar la página
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Éxito',
                    text: '{{ session('success') }}',
                    confirmButtonText: 'Aceptar'
                });
            @endif

            @if(session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: '{{ session('error') }}',
                    confirmButtonText: 'Aceptar'
                });
            @endif
        });
    </script>
</body>
</html>
