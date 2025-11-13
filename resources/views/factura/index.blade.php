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
@php
    $userName = session('user_name');
    $profileType = session('profile_type');
@endphp
    <div class="container mt-5">
        <h3>Lista de Presupuestos</h3>

        <form action="{{ route('factura.index') }}" method="GET" class="mb-3">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Buscar por cliente, empresa o fecha..." value="{{ request('search') }}">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit">Buscar</button>
                </div>
            </div>

            @if( $profileType==1 or $profileType==2 )
            <a href="{{ route('buscar', ['id' => 1]) }}" class="btn btn-success mb-3">Crear Presupuesto Steel</a>
            @endif

            <a href="{{ route('buscar', ['id' => 2]) }}" class="btn btn-primary mb-3">Crear Presupuesto TuCocina</a>

            <table class="table table-bordered">
                <thead class="thead-light">
                    <tr>
                        <th>N°</th>
                        <th>Creado Por</th>
                        <th>Cliente</th>
                        <th>Empresa</th>
                        <th>Fecha</th>
                        <th>Subtotal</th>
                        <th>IVA</th>
                        <th>Total</th>
                        <th>Condiciones de Pago</th>
                        <th>Validez</th>
                        <th>Estatus</th>
                        <th>Acciones</th>
                        <th>Descargar Pdf</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($presupuestos as $presupuesto)
                    <tr>
                        <td>{{ $presupuesto->id }}</td>
                        <td>{{ $presupuesto->user->name ?? 'Sin nombre' }}</td>
                        <td>{{ $presupuesto->cliente->nombre }}</td>
                        <td>{{ $presupuesto->empresa->razon_social }}</td>
                        <td>{{ $presupuesto->fecha }}</td>
                        <td>{{ number_format($presupuesto->subtotal, 2, ',', '.') }} </td>
                        <td>{{ number_format($presupuesto->iva, 2, ',', '.') }} </td>
                        <td>{{ number_format($presupuesto->total, 2, ',', '.') }} </td>
                        <td>{{ $presupuesto->condiciones_pago }}</td>
                        <td>{{ $presupuesto->validez }}</td>
                        <td>
                            @if($presupuesto->estatus_presupuesto)
                                <span class="estatus-badge estatus-{{ $presupuesto->estado->estatus ? 'activo' : 'inactivo' }}">
                                    {{ $presupuesto->estado->nombre }}
                                </span>
                            @else
                                <span class="bg-danger text-white p-2 rounded">{{ $presupuesto->estado->nombre }}</span>
                            @endif
                        </td>
                        <td>
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

                            <!-- Botón para enviar a EN EVALUACIÓN o APROBADO -->
                            @if($presupuesto->estado)
                                @if($presupuesto->estatus_presupuesto == 1)
                                    <form action="{{ route('status.presupuesto', $presupuesto->id) }}" method="POST" class="status-form" style="display:inline;">
                                        @csrf
                                        <input type="hidden" name="_method" value="PUT">
                                        <input type="hidden" name="nuevo_estado" value="2"> <!-- Valor para EN EVALUACIÓN -->
                                        <button type="submit" class="btn btn-success status-button">
                                            <i class="fas fa-check"></i> Evaluación
                                        </button>
                                    </form>
                                @elseif($presupuesto->estatus_presupuesto == 2)
                                    <form action="{{ route('status.presupuesto', $presupuesto->id) }}" method="POST" class="status-form" style="display:inline;">
                                        @csrf
                                        <input type="hidden" name="_method" value="PUT">
                                        <input type="hidden" name="nuevo_estado" value="3"> <!-- Valor para APROBADO -->
                                        <button type="submit" class="btn btn-success status-button">
                                            <i class="fas fa-check"></i> Aprobar
                                        </button>
                                    </form>
                                @elseif($presupuesto->estatus_presupuesto == 3)
                                    <form action="{{ route('status.presupuesto', $presupuesto->id) }}" method="POST" class="status-form" style="display:inline;">
                                        @csrf
                                        <input type="hidden" name="_method" value="PUT">
                                        <input type="hidden" name="nuevo_estado" value="4"> <!-- Valor para FABRICACIÓN -->
                                        <button type="submit" class="btn btn-success status-button">
                                            <i class="fas fa-check"></i> Fabricación
                                        </button>
                                    </form>
                                @elseif($presupuesto->estatus_presupuesto == 4)
                                    <form action="{{ route('status.presupuesto', $presupuesto->id) }}" method="POST" class="status-form" style="display:inline;">
                                        @csrf
                                        <input type="hidden" name="_method" value="PUT">
                                        <input type="hidden" name="nuevo_estado" value="5"> <!-- Valor para ENTREGADO -->
                                        <button type="submit" class="btn btn-success status-button">
                                            <i class="fas fa-check"></i> Entregado
                                        </button>
                                    </form>
                                @elseif($presupuesto->estatus_presupuesto == 5)
                                    <!-- No se muestra ningún botón -->
                                    <span class="text-muted"></span>
                                @endif

                                <!-- Botón para anular (solo si el estado es 1, 2, 3 o 4) -->
                                @if($presupuesto->estatus_presupuesto >= 1 && $presupuesto->estatus_presupuesto < 2)
                                    <form action="{{ route('status.presupuesto', $presupuesto->id) }}" method="POST" class="status-form" style="display:inline;">
                                        @csrf
                                        <input type="hidden" name="_method" value="PUT">
                                        <input type="hidden" name="nuevo_estado" value="0"> <!-- Valor para ANULAR -->
                                        <button type="submit" class="btn btn-danger status-button">
                                            <i class="fas fa-ban"></i> Anular
                                        </button>
                                    </form>
                                @endif
                            @endif
                        </td>

                        <!-- Sección para los PDFs -->
                        <td>
                            <!-- Siempre mostrar el enlace para descargar el presupuesto -->
                            @if($presupuesto->estatus_presupuesto <= 5)
                                <a href="{{ route('presupuestos.pdf', $presupuesto->id) }}" class="btn btn-primary" title="Presupuesto {{ $presupuesto->id }}">
                                    <i class="fas fa-file-pdf"></i>
                                </a>
                            @endif

                            @if($presupuesto->estatus_presupuesto >= 4)
                                <a href="{{ route('presupuestos.pdf.orden', $presupuesto->id) }}" class="btn btn-success" title="Orden de Producción - Presupuesto {{ $presupuesto->id }}">
                                    <i class="fas fa-file-pdf"></i>
                                </a>
                            @endif

                            @if($presupuesto->estatus_presupuesto > 4 )
                                <a href="{{ route('presupuestos.pdf.nota', $presupuesto->id) }}" class="btn btn-danger" title="Nota de entrega - Presupuesto {{ $presupuesto->id }}">
                                    <i class="fas fa-file-pdf"></i>
                                </a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Paginación -->
            <div class="d-flex justify-content-center">
                {{ $presupuestos->appends(request()->except('page'))->links('pagination::bootstrap-4') }} <!-- Esto genera los enlaces de paginación -->
            </div>
        </form>
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

            // Manejar el evento de envío de formularios de cambio de estado
            const statusForms = document.querySelectorAll('.status-form');

            statusForms.forEach(form => {
                form.addEventListener('submit', function(event) {
                    event.preventDefault(); // Prevenir el envío del formulario

                    const nuevoEstado = form.querySelector('input[name="nuevo_estado"]').value;

                    Swal.fire({
                        title: '¿Estás seguro?',
                        text: `¿Deseas cambiar el estado a ${nuevoEstado}?`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Sí, cambiar!',
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
