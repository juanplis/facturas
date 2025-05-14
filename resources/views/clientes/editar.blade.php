<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Editar Cliente</title>
</head>
<body>
    <div class="container">
        <h1>Editar Cliente</h1>
        <form action="{{ route('user.actualiza', $cliente->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" class="form-control" name="nombre" value="{{ $cliente->nombre }}" required>
            </div>
            <div class="form-group">
                <label for="rif">RIF</label>
                <input type="text" class="form-control" name="rif" value="{{ $cliente->rif }}" required>
            </div>
            <div class="form-group">
                <label for="direccion">Dirección</label>
                <input type="text" class="form-control" name="direccion" value="{{ $cliente->direccion }}" required>
            </div>
            <div class="form-group">
                <label for="telefono">Teléfono</label>
                <input type="text" class="form-control" name="telefono" value="{{ $cliente->telefono }}" required>
            </div>
            <div class="form-group">
                <label for="correo">Correo</label>
                <input type="email" class="form-control" name="correo" value="{{ $cliente->correo }}" required>
            </div>
            <button type="submit" class="btn btn-success">Actualizar Cliente</button>
        </form>
    </div>
</body>
</html>
