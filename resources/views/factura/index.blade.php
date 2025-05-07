<!DOCTYPE html>
<html lang="en">
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
                    <td>
                        <a href="{{ route('factura.edita', $presupuesto->id) }}" class="btn btn-primary">Editar</a>
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                        <a href="" class="btn btn-info">Ver</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</html>

