<!DOCTYPE html>
<html lang="es">
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    @include('menu')
    <title>Tasa BCV</title>
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
        <h3>Lista de Tasas BCV</h3>
        <form action="{{ route('tasa_bcv.index') }}" method="GET" class="mb-3">
            <a href="{{ route('tasa_bcv.create') }}" class="btn btn-primary mb-3">Crear Nueva Tasa BCV</a>
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Buscar por fecha o monto..." value="{{ request('search') }}">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit">Buscar</button>
                </div>
            </div>
        </form>

        <div class="row mb-3">
            <div class="col-md-10">
                <h4>Agregar Porcentaje</h4>
                <form action="{{ route('manejo_porcentaje.store') }}" method="POST">
                    @csrf

                    <div class="form-group">
                        <label for="porcentaje">Porcentaje (Máx. 2 decimales, ej: 0.26):</label>

                        {{-- INICIO DE LA FILA PARA ALINEAR INPUT Y ALERTA --}}
                        <div class="row">

                            {{-- Columna para el Input con ID --}}
                            <div class="col-md-4">
                                <input type="number" step="0.01" name="porcentaje" class="form-control" id="input-porcentaje" required>
                            </div>

                            {{-- Columna para la Alerta --}}
                            <div class="col-md-8">
                                <div class="alert alert-info p-2 m-0" style="font-size: 0.9em;">
                                    @if ($ultimo_porcentaje)
                                        El último porcentaje de inventario registrado es
                                        <strong>{{ number_format($ultimo_porcentaje->porcentaje, 2) }}</strong>
                                        <span class="text-muted"> de Fecha {{ $ultimo_porcentaje->created_at->format('d/m/Y') }}</span>
                                    @else
                                        <span class="text-danger">No hay registros de porcentaje.</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        {{-- FIN DE LA FILA --}}
                    </div>

                    <button type="submit" class="btn btn-success mt-2">Guardar Porcentaje</button>

                </form>
            </div>
        </div>

        <hr>

        <h4>Lista de Tasas BCV</h4>
        <table class="table table-bordered">
            <thead class="thead-light">
                <tr>
                    <th>N°</th>
                    <th>Fecha</th>
                    <th>Monto BCV</th>
                    <th>Monto Euro</th>
                    <th>Intervenciones</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tasa_bcvs as $tasa)
                    <tr>
                        <td>{{ $tasa->id }}</td>
                        <td>{{ $tasa->fecha_bcv }}</td>
                        <td>{{ $tasa->monto_bcv }}</td>
                        <td>{{ $tasa->monto_bcv_euro }}</td>
                        <td>{{ $tasa->intervenciones }}</td>
                        <td>
                            <div class="btn-group" role="group" aria-label="Acciones">
                                <a href="{{ route('tasa_bcv.edit', $tasa->id) }}" class="btn btn-primary">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                                <form action="{{ route('tasa_bcv.destroy', $tasa->id) }}" method="POST" style="display:inline;" class="delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger delete-button" data-id="{{ $tasa->id }}">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const inputPorcentaje = document.getElementById('input-porcentaje');

            if (inputPorcentaje) {
                // Función principal que filtra y formatea mientras se escribe
                function filtrarYFormatearDecimal(event) {
                    let valor = inputPorcentaje.value;

                    // 1. Limpieza inicial: Permite solo números y puntos
                    valor = valor.replace(/[^0-9.]/g, '');

                    // 2. Control de Múltiples Puntos
                    let partes = valor.split('.');
                    if (partes.length > 2) {
                        // Si hay más de un punto, solo mantenemos el primero y eliminamos los demás
                        valor = partes[0] + '.' + partes.slice(1).join('');
                    }

                    // 3. Restricción de Decimales (Máximo dos después del punto)
                    partes = valor.split('.'); // Volvemos a dividir por si hubo corrección
                    if (partes.length === 2 && partes[1].length > 2) {
                        // Mantenemos solo los dos primeros decimales
                        valor = partes[0] + '.' + partes[1].substring(0, 2);
                    }

                    // 4. Conversión de enteros (26 -> 0.26) solo si el usuario escribió dos o más dígitos sin punto
                    partes = valor.split('.');
                    if (partes.length === 1 && partes[0].length >= 2) {
                        let num = parseFloat(partes[0]);
                        if (!isNaN(num) && num >= 1) {
                            num = num / 100;
                            // Reemplazamos el valor con el decimal formateado
                            valor = num.toFixed(2);
                        }
                    }

                    // 5. Caso especial: si el valor es solo un punto, lo convertimos a "0."
                    if (valor === '.') {
                        valor = '0.';
                    }

                    // Actualizar el valor del input solo si hubo cambios
                    if (inputPorcentaje.value !== valor) {
                        inputPorcentaje.value = valor;
                    }
                }

                // Aplicar la función mientras el usuario interactúa (escribe o pega)
                inputPorcentaje.addEventListener('input', filtrarYFormatearDecimal);
            }
        });
    </script>
</body>
</html>
