<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orden de Presupuesto</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Orden de Presupuesto</h1>

        <div class="card">
            <div class="card-body">
                <h2>Detalles del Presupuesto</h2>
                <hr>
                <p><strong>ID del Presupuesto:</strong> {{ $ID }}</p> <!-- Mostrar el ID del presupuesto -->
                <p><strong>Cliente:</strong> {{ $Nombre }}</p>
                <p><strong>Fecha:</strong> {{ $Fecha }}</p>
                <p><strong>Subtotal:</strong> ${{ number_format($Subtotal, 2) }}</p>
                <p><strong>Total:</strong> ${{ number_format($Total, 2) }}</p>
                <p><strong>Condiciones de Pago:</strong> {{ $Condiciones_Pago }}</p>
                <p><strong>Validez:</strong> {{ $Validez }}</p>

                <h3>Descripción de Productos</h3>
                <ul class="list-group">
                    @foreach($Descripcion as $index => $descripcion)
                        <li class="list-group-item">
                            <strong>Descripción:</strong> {{ $descripcion }}<br>
                        
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</body>
</html>

