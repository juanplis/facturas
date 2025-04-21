<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Presupuesto</title>
</head>
<body>
    @include('menu')

    <h1>Detalles del Presupuesto</h1>
    
    <p>Fecha: {{ $presupuesto->Fecha }}</p>
    <p>Subtotal: {{ $presupuesto->Subtotal }}</p>
    <p>Total: {{ $presupuesto->Total }}</p>
    <p>Condiciones de Pago: {{ $presupuesto->Condiciones_Pago }}</p>
    <p>Validez: {{ $presupuesto->Validez }}</p>

    <h3>Items</h3>
    <table>
        <thead>
            <tr>
                <th>Descripción</th>
                <th>Cantidad</th>
                <th>Precio Unitario</th>
                <th>Precio Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $item)
                <tr>
                    <td>{{ $item->Descripcion }}</td>
                    <td>{{ $item->Cantidad }}</td>
                    <td>{{ $item->Precio_Unitario }}</td>
                    <td>{{ $item->Precio_Total }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
