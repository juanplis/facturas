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

    <p>Fecha: {{ $presupuesto->fecha }}</p>
    <p>Subtotal: {{ $presupuesto->subtotal }}</p>
    <p>Total: {{ $presupuesto->total }}</p>
    <p>Condiciones de Pago: {{ $presupuesto->condiciones_Pago }}</p>
    <p>Validez: {{ $presupuesto->validez }}</p>

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
                    <td>{{ $item->descripcion }}</td>
                    <td>{{ $item->cantidad }}</td>
                    <td>{{ $item->precio_Unitario  }}</td>
                    <td>{{ $item->precio_Total }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
