<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Presupuesto</title>
    <!-- Enlace a Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Enlace a Select2 CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
</head>
<body>
    @include('menu')

    <div class="container mt-5">
        <h1 class="text-center">Editar Tasa BCV</h1>
        <div class="card">
            <div class="card-body">

                <form action="{{ route('tasa_bcv.update', $tasa_bcv->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label for="fecha_bcv">Fecha:</label>
        <input type="date" name="fecha_bcv" value="{{ old('fecha_bcv', $tasa_bcv->fecha_bcv) }}" required>

        <label for="monto_bcv">Monto BCV:</label>
        <input type="number" step="0.01" name="monto_bcv" value="{{ old('monto_bcv', $tasa_bcv->monto_bcv) }}" required>

        <label for="monto_bcv_euro">Monto Euro:</label>
        <input type="number" step="0.01" name="monto_bcv_euro" value="{{ old('monto_bcv_euro', $tasa_bcv->monto_bcv_euro) }}" required>

        <label for="intervenciones">Intervenciones:</label>
        <input type="text" name="intervenciones" value="{{ old('intervenciones', $tasa_bcv->intervenciones) }}" required maxlength="30">

        <button type="submit">Actualizar</button>
    </form>
</div>
        </div>
    </div>

    <!-- Enlace a Bootstrap JS y dependencias -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Enlace a Select2 JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    
</body>
</html>
