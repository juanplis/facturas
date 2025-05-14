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
    <title>Lista de Presupuestos</title>
    <style>
        /* Estilo para filas alternas */
        tbody tr:nth-child(odd) {
            background-color: #f8f9fa; /* Color gris claro */
        }
        tbody tr:nth-child(even) {
            background-color: #ffffff; /* Color blanco */
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1>Lista de Presupuestos</h1>
        <a href="{{ route('buscar') }}" class="btn btn-primary mb-3">Crear Presupuesto</a>
        <table class="table table-bordered">
            <thead class="thead-light">
                <tr>
                    <th>Cliente ID</th>
                    <th>Fecha</th>
                    <th>Subtotal</th>
                    <th>IVA</th>
                    <th>Total</th>
                    <th>Condiciones de Pago</th>
                    <th>Tiempo Entrega</th>
                    <th>Validez</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($presupuesto as $presupuesto)
                <tr>
                    <td>{{ $presupuesto->cliente_id }}</td>
                    <td>{{ $presupuesto->fecha }}</td>
                    <td>{{ $presupuesto->subtotal }}</td>
                    <td>{{ $presupuesto->iva }}</td>
                    <td>{{ $presupuesto->total }}</td>
                    <td>{{ $presupuesto->condiciones_pago }}</td>
                    <td>{{ $presupuesto->tiempo_entrega }}</td>
                    <td>{{ $presupuesto->validez }}</td>
                    <td>
                        <a href="{{ route('factura.ver', $presupuesto->id) }}" class="btn btn-info">
                            <i class="fas fa-eye"></i> <!-- Icono de ojo -->
                        </a>
                        <a href="{{ route('factura.edita', $presupuesto->id) }}" class="btn btn-primary">
                            <i class="fas fa-pencil-alt"></i> <!-- Icono de lápiz -->
                        </a>
                        <form action="{{ route('factura.elimina', $presupuesto->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de que quieres eliminar este presupuesto?');">
                                <i class="fas fa-trash-alt"></i> <!-- Icono de papelera -->
                            </button>
                        </form>
                        <a href="{{ route('presupuestos.pdf', $presupuesto->id) }}" class="btn btn-success">
                            <i class="fas fa-file-pdf"></i> <!-- Icono de PDF -->
                        </a>
                    </td>
                </tr>
                @endforeach
            </


