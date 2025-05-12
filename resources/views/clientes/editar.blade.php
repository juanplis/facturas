<!DOCTYPE html>
<html lang="es">
        <!-- Enlace a Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Enlace a Select2 CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    @include('menu')
    <h1>Editar Cliente</h1>

    <form >
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="">Nombre</label>
            <input type="text" name="Nombre" class="form-control" value="{{ $cliente->nombre }}" required>
        </div>
        <div class="form-group">
            <label for="subtotal">RIF</label>
            <input type="number" step="0.01" name="Rif" class="form-control" value="{{ $cliente->rif }}" required>
        </div>
        <div class="form-group">
            <label for="iva">Dirección</label>
            <input type="text" step="0.01" name="Direccion" class="form-control" value="{{ $cliente->direccion }}" required>
        </div>
        <div class="form-group">
            <label for="total">Teléfono</label>
            <input type="number" step="0.01" name="Telefono" class="form-control" value="{{ $cliente->telefono }}" required>
        </div>
        <div class="form-group">
            <label for="condiciones_pago">Correo</label>
            <input type="email" name="Correo" class="form-control" value="{{ $cliente->correo }}" required>
        </div>
        <button type="submit" class="btn btn-success">Actualizar</button>
    </form>
</body>
</html>