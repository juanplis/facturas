<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Presupuesto</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h1>Presupuesto</h1>
    <p><strong>Cliente:</strong> {{ $cliente }}</p>
    <p><strong>RIF:</strong> {{ $rif }}</p>
    <p><strong>Dirección:</strong> {{ $direccion }}</p>
    <p><strong>Teléfono:</strong> {{ $telefono }}</p>
    <p><strong>Fecha:</strong> {{ $fecha }}</p>
    <h2>Items</h2>
    <table>
        <thead>
            <tr>
                <th>Código</th>
                <th>Descripción</th>
                <th>Cantidad</th>
                <th>Precio Unitario</th>
                <th>Precio Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($items as $item)
            <tr>
                <td>{{ $item['cod'] }}</td>
                <td>{{ $item['descripcion'] }}</td>
                <td>{{ $item['cant'] }}</td>
                <td>{{ number_format($item['precio_unitario'], 2) }} USD</td>
                <td>{{ number_format($item['precio_total'], 2) }} USD</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <p><strong>SUB-TOTAL USD:</strong> {{ number_format($sub_total, 2) }}</p>
    <p><strong>IVA 16%:</strong> {{ number_format($iva, 2) }}</p>
    <p><strong>TOTAL USD:</strong> {{ number_format($total, 2) }}</p>
    <p><strong>Condiciones de Pago:</strong> {{ $condiciones_pago }}</p>
    <p><strong>Tiempo de Entrega Aproximado:</strong> {{ $tiempo_entrega }}</p>
</body>
</html>
