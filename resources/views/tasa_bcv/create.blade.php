<!DOCTYPE html>
<html lang="es">
<head>
    <!-- Enlace a Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Enlace a Select2 CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    @include('menu')
    <title>Crear Cliente</title>
</head>
<body>
    <div class="container mt-5">
        <h3>Crear Tasa BCV</h3>
    <form action="{{ route('tasa_bcv.store') }}" method="POST">
        @csrf
        <label for="fecha_bcv">Fecha:</label>
        <input type="date" name="fecha_bcv" required>

        <label for="monto_bcv">Monto BCV:</label>
        <input type="number" step="0.01" name="monto_bcv" required>

        <label for="monto_bcv_euro">Monto Euro:</label>
        <input type="number" step="0.01" name="monto_bcv_euro" required>

        <label for="intervenciones">Intervenciones:</label>
        <input type="number" name="intervenciones" required maxlength="4">

        <button type="submit">Guardar</button>
    </form>
</div>
</body>
</html>
