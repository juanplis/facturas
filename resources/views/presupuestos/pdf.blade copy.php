<!DOCTYPE html>
<html>
<head>
    <style>
        .header { margin-bottom: 20px; }
        .table { width: 100%; border-collapse: collapse; }
        .table th, .table td { border: 1px solid #000; padding: 8px; }
        .text-right { text-align: right; }
        .mb-4 { margin-bottom: 1rem; }
    </style>
</head>
<body>
    <div class="header">
        <h2>SSC{{ str_pad($presupuesto->id, 5, '0', STR_PAD_LEFT) }}</h2>
        <p>CLIENTE: {{ $presupuesto->clientes->nombre }}</p>
        <p>RIF: {{ $presupuesto->clientes->rif }}</p>
        <p>FECHA: {{ \Carbon\Carbon::parse($presupuesto->fecha)->format('d/m/Y') }}</p>

    </div>

    <table class="table mb-4">
        <thead>
            <tr>
                <th>COD</th>
                <th>DESCRIPCIÓN</th>
                <th>CANT</th>
                <th>PRECIO UNITARIO</th>
                <th>PRECIO TOTAL</th>
            </tr>
        </thead>
        <tbody>
            @foreach($presupuesto->items as $item)
            <tr>
                <td>{{ $item->codigo }}</td>
                <td>{{ $item->descripcion }}</td>
                <td>{{ $item->cantidad }}</td>
                <td class="text-right">${{ number_format($item->precio_unitario, 2) }}</td>
                <td class="text-right">${{ number_format($item->precio_total, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="totals">
        <p class="text-right">SUB-TOTAL USD: ${{ number_format($presupuesto->subtotal, 2) }}</p>
        <p class="text-right">Descuento: ${{ number_format($presupuesto->descuento ?? 0, 2) }}</p>
        <p class="text-right">TOTAL USD: ${{ number_format($presupuesto->total, 2) }}</p>
    </div>
</body>
</html>
