<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Detalles del Presupuesto</title>
    <!-- Enlace a Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Enlace a Select2 CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
</head>
<body>
    @include('menu')

    <div class="container mt-5">
        <h1 class="text-center mb-4">Detalles del Presupuesto</h1>
        <p><strong>Cliente ID:</strong> {{ $presupuesto->cliente_id }}</p>
        <p><strong>Fecha:</strong> {{ $presupuesto->fecha }}</p>
        <p><strong>Subtotal:</strong> {{ $presupuesto->subtotal }}</p>
        <p><strong>IVA:</strong> {{ $presupuesto->iva }}</p>
        <p><strong>Total:</strong> {{ $presupuesto->total }}</p>
        <p><strong>Condiciones de Pago:</strong> {{ $presupuesto->condiciones_pago }}</p>
        <p><strong>Tiempo de Entrega:</strong> {{ $presupuesto->tiempo_entrega }} días</p>
        <p><strong>Validez:</strong> {{ $presupuesto->validez }}</p>
        <a href="{{ route('factura.index') }}" class="btn btn-primary">Volver</a>
    </div>

    <!-- Enlace a Bootstrap JS y jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
