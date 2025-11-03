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
        

        <form action="{{ route('user.store') }}" method="POST">
            @csrf
          
          <div class="row">
            <div class="col-md-6">
                <h3>Crear Cliente</h3>
              <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" id="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="rif">RIF</label>
                <input type="text" name="rif" id="rif" class="form-control" maxlength="11" required>
            </div>
            <div class="form-group">
                <label for="direccion">Dirección</label>
                <input type="text" name="direccion" id="direccion" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="telefono">Teléfono</label>
                <input type="text" name="telefono" id="telefono" class="form-control" maxlength="11" onkeypress="return event.charCode>=48 && event.charCode<=57" required>
            </div>
            <div class="form-group">
                <label for="correo">Correo</label>
                <input type="text" name="correo" id="correo" class="form-control" value="sin_correo@gmail.com">
            </div>
            </div>
            <div class="col-md-6">
                <h3>Contactos (Personas Naturales)</h3>
                   <div class="form-group">
                <label for="nombre_contacto">Nombre del Contacto</label>
                <input type="text" class="form-control" id="nombre_contacto" name="nombre_contacto" value="S/C">
            </div>
            <div class="form-group">
                <label for="telefono_contacto">Teléfono del Contacto</label>
                <input type="text" class="form-control" id="telefono_contacto" name="telefono_contacto" maxlength="11" onkeypress="return event.charCode>=48 && event.charCode<=57" value="S/T">
            </div>
            <div class="form-group">
                <label for="correo_contacto">Correo del Contacto</label>
                <input type="text" class="form-control" id="correo_contacto" name="correo_contacto" value="sin_correo@gmail.com">
            </div>
            </div>
          </div>
            

       

            <button type="submit" class="btn btn-success">Crear Cliente</button>
        </form>
    </div>
</body>
</html>