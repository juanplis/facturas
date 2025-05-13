<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>Cliente</th>
            <th>Total</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($presupuestos as $presupuesto)
        <tr>
            <td>{{ $presupuesto->id }}</td>
            <td>{{ $presupuesto->clientes->nombre }}</td>
            <td>${{ number_format($presupuesto->total, 2) }}</td>
            <td>
                <a href="{{ route('presupuestos.pdf', $presupuesto->id) }}"
                   class="btn btn-primary">
                   Generar PDF
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
