<!DOCTYPE html>
<html lang="es">
<head>
    <!-- Enlace a Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Enlace a Select2 CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    @include('menu')
    <title>Editar Cliente</title>
</head>
<body>
    <div class="container mt-5">
        <!--h3>Editar Cliente</h3-->

        <form action="{{ route('user.actualiza', $cliente->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                <!-- Información del Cliente -->
                <div class="col-md-6">
                    <!--h3>Información del Cliente</h3-->
                    <h3>Editar Cliente</h3>
                    <div class="form-group">
                        <label for="nombre">Nombre</label>
                        <input type="text" id="nombre" name="nombre" class="form-control" value="{{ $cliente->nombre }}" required>
                    </div>
                    <div class="form-group">
                        <label for="rif">RIF</label>
                        <input type="text" id="rif" name="rif" class="form-control" value="{{ $cliente->rif }}" maxlength="11"  required>
                    </div>
                    <div class="form-group">
                        <label for="direccion">Dirección</label>
                        <input type="text" id="direccion" name="direccion" class="form-control" value="{{ $cliente->direccion }}" required>
                    </div>
                    <div class="form-group">
                        <label for="telefono">Teléfono</label>
                        <input type="text" id="telefono" name="telefono" class="form-control" value="{{ $cliente->telefono }}" maxlength="11" onkeypress="return event.charCode>=48 && event.charCode<=57" required>
                    </div>
                    <div class="form-group">
                        <label for="correo">Correo</label>
                        <input type="text" id="correo" name="correo" class="form-control" value="{{ $cliente->correo }}" required>

                    </div>
                </div>

                <!-- Información del Contacto -->
                <div class="col-md-6">
                    <h3>Contactos (Personas Naturales)</h3>
                    <div class="form-group">
                        <label for="nombre_contacto">Nombre del Contacto</label>
                        <input type="text" class="form-control" id="nombre_contacto" name="nombre_contacto" value="{{ $cliente->contacto->nombre }}" required>
                    </div>
                    <div class="form-group">
                        <label for="telefono_contacto">Teléfono del Contacto</label>
                        <input type="text" class="form-control" id="telefono_contacto" name="telefono_contacto" value="{{ $cliente->contacto->telefono }}" maxlength="11" onkeypress="return event.charCode>=48 && event.charCode<=57" required>
                    </div>
                    <div class="form-group">
                        <label for="correo_contacto">Correo del Contacto</label>
                        <input type="text" class="form-control" id="correo_contacto" name="correo_contacto" value="{{ $cliente->contacto->correo}}"  required>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-success">Actualizar Cliente</button>
        </form>
    </div>
</body>
</html>