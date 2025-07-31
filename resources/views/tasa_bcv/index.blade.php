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

    </style>
</head>
<body>
    <div class="container mt-5">
    <h1>Lista de Tasas BCV</h1>
    <a href="{{ route('tasa_bcv.create') }}">Crear Nueva Tasa BCV</a>

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
            <tr>
                 <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                 <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                 <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Monto BCV</th>
                 <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Monto Euro</th>
                 <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Intervenciones</th>
                 <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
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
                        <a href="{{ route('tasa_bcv.edit', $tasa->id) }}">Editar</a>
                        <form action="{{ route('tasa_bcv.destroy', $tasa->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
</body>
</html>
