<!DOCTYPE html>
<html lang="es">
<head>
    <!-- Enlace a Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Enlace a Select2 CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    @include('menu')
    <title>Crear Cliente</title>
</head>
<body>
    <div class="container mt-5">
        <h1>Crear Cliente</h1>

        <form action="{{ route('user.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="rif">RIF</label>
                <input type="text" name="rif" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="direccion">Dirección</label>
                <input type="text" name="direccion" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="telefono">Teléfono</label>
                <input type="text" name="telefono" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="correo">Correo</label>
                <input type="email" name="correo" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success">Crear Cliente</button>
        </form>

        <hr>

        <h2>Contactos (Personas Naturales)</h2>
        <form action="{{ route('contactos.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="nombre_contacto">Nombre</label>
                <input type="text" class="form-control" id="nombre_contacto" name="nombre_contacto" required>
            </div>
            <div class="form-group">
                <label for="telefono_contacto">Teléfono</label>
                <input type="text" class="form-control" id="telefono_contacto" name="telefono_contacto" required>
            </div>
            <div class="form-group">
                <label for="correo_contacto">Correo</label>
                <input type="email" class="form-control" id="correo_contacto" name="correo_contacto" required>
            </div>
            <div class="form-group">
                <label for="cliente_id">Cliente ID</label>
                <input type="text" class="form-control" id="cliente_id" name="cliente_id" required>
            </div>
            <button type="submit" class="btn btn-primary">Agregar Contacto</button>
        </form>
    </div>
</body>
</html>
