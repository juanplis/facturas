    <!DOCTYPE html>
    <html lang="es">
            <!-- Enlace a Bootstrap CSS -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <!-- Enlace a Select2 CSS -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
        @include('menu')
        <h1>Crear Cliente</h1>

        <form action="{{ route('user.update') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" class="form-control">
            </div>
            <div class="form-group">
                <label for="rif">RIF</label>
                <input type="number" step="0.01" name="rif" class="form-control">
            </div>
            <div class="form-group">
                <label for="direccion">Dirección</label>
                <input type="text" step="0.01" name="direccion" class="form-control">
            </div>
            <div class="form-group">
                <label for="telefono">Teléfono</label>
                <input type="number" step="0.01" name="telefono" class="form-control">
            </div>
            <div class="form-group">
                <label for="correo">Correo</label>
                <input type="email" name="correo" class="form-control">
            </div>
            <button type="submit" class="btn btn-success">Crear</button>



        </form>
    </body>
    </html>