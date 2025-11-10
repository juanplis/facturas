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
        .form-group label {
            font-weight: bold;
        }
        .btn-custom {
            background-color: #007bff;
            color: white;
        }
    </style>
</head>
<body>

    <div class="container mt-5">
        <h3 class="mb-4">Editar Tasa BCV</h3>
        <form action="{{ route('tasa_bcv.update', $tasa_bcv->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="fecha_bcv">Fecha:</label>
                <input type="date" class="form-control" name="fecha_bcv" value="{{ old('fecha_bcv', $tasa_bcv->fecha_bcv) }}" required>
            </div>

            <div class="form-group">
                <label for="monto_bcv">Monto BCV:</label>
                <input type="number" class="form-control" step="0.01" name="monto_bcv" value="{{ old('monto_bcv', $tasa_bcv->monto_bcv) }}" required>
            </div>

            <div class="form-group">
                <label for="monto_bcv_euro">Monto Euro:</label>
                <input type="number" class="form-control" step="0.01" name="monto_bcv_euro" value="{{ old('monto_bcv_euro', $tasa_bcv->monto_bcv_euro) }}" required>
            </div>

            <div class="form-group">
                <label for="intervenciones">Intervenciones:</label>
                <input type="number" class="form-control" name="intervenciones" value="{{ old('intervenciones', $tasa_bcv->intervenciones) }}" required maxlength="4">
            </div>

            <button type="submit" class="btn btn-custom">Actualizar</button>
        </form>
    </div>

    <!-- Enlace a jQuery y Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
