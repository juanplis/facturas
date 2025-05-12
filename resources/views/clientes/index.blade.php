<!DOCTYPE html>
<html>
          <!-- Enlace a Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Enlace a Select2 CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
 @include('menu')
<head>
    <title>Clientes</title>
</head>
<body>
    <h1>Lista de Clientes</h1>
    <a href="{{ route('user.crear')}}" method="POST" class="btn btn-primary">Crear Cliente</a>
    <table class="table">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>RIF</th>
                <th>Dirección</th>
                <th>Teléfono</th>
                <th>Correo</th>
            </tr>
        </thead>
        <tbody>
            @foreach($clientes as $cliente)
            <tr>
                <td>{{ $cliente->nombre }}</td>
                <td>{{ $cliente->rif }}</td>
                <td>{{ $cliente->direccion }}</td>
                <td>{{ $cliente->telefono }}</td>
                <td>{{ $cliente->correo }}</td>
                 <td>
                        <a href="{{ route('user.update', $cliente->id) }}" class="btn btn-primary">Editar</a>
                        <button type="submit" class="btn btn-danger">Eliminar</button>
                 </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
