<!DOCTYPE html>
<html lang="en">
        <!-- Enlace a Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Enlace a Select2 CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
 @include('menu')
    <h1>Lista de Presupuesto</h1>
    <a href="{{ route('buscar')}}" method="POST" class="btn btn-primary">Crear Presupuesto</a>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Cliente ID</th>
                <th>Fecha</th>
                <th>Subtotal</th>
                <th>IVA</th>
                <th>Total</th>
                <th>condiciones de pago</th>
                <th>tiempo entrega</th>
                <th>validez</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($presupuesto as $presupuesto)
                <tr>
                    <td>{{ $presupuesto->id }}</td>
                    <td>{{ $presupuesto->cliente_id }}</td>
                    <td>{{ $presupuesto->fecha }}</td>
                    <td>{{ $presupuesto->subtotal }}</td>
                    <td>{{ $presupuesto->iva }}</td>
                    <td>{{ $presupuesto->total }}</td>
                    <td>{{ $presupuesto->condiciones_pago }}</td>
                    <td>{{ $presupuesto->tiempo_entrega }}</td>
                    <td>{{ $presupuesto->validez }}</td>
                    <td>
                        <a href="{{ route('factura.edita', $presupuesto->id) }}" class="btn btn-primary">Editar</a>
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                        <a href="{{ route('factura.show', $presupuesto->id) }}" class="btn btn-info">Ver</a>

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
</html>

