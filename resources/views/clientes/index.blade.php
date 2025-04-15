<!DOCTYPE html>
<html>
<head>
    <title>Clientes</title>
</head>
<body>
    <h1>Lista de Clientes</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
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
                <td>{{ $cliente->ID }}</td>
                <td>{{ $cliente->Nombre }}</td>
                <td>{{ $cliente->RIF }}</td>
                <td>{{ $cliente->Direccion }}</td>
                <td>{{ $cliente->Telefono }}</td>
                <td>{{ $cliente->Correo }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
