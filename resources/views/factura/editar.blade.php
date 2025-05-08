<!DOCTYPE html>
<html lang="es">
        <!-- Enlace a Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Enlace a Select2 CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    @include('menu')
    <h1>Editar Presupuesto</h1>

    <form action="{{ route('factura.update', $presupuesto->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="cliente_id">Cliente ID</label>
            <input type="number" name="cliente_id" class="form-control" value="{{ $presupuesto->cliente_id }}" required>
        </div>
        <div class="form-group">
            <label for="fecha">Fecha</label>
            <input type="date" name="fecha" class="form-control" value="{{ $presupuesto->fecha }}" required>
        </div>
        <div class="form-group">
            <label for="subtotal">Subtotal</label>
            <input type="number" step="0.01" name="subtotal" class="form-control" value="{{ $presupuesto->subtotal }}" required>
        </div>
        <div class="form-group">
            <label for="iva">IVA</label>
            <input type="number" step="0.01" name="iva" class="form-control" value="{{ $presupuesto->iva }}" required>
        </div>
        <div class="form-group">
            <label for="total">Total</label>
            <input type="number" step="0.01" name="total" class="form-control" value="{{ $presupuesto->total }}" required>
        </div>
        <div class="form-group">
            <label for="condiciones_pago">Condiciones de Pago</label>
            <input type="text" name="condiciones_pago" class="form-control" value="{{ $presupuesto->condiciones_pago }}" required>
        </div>
        <div class="form-group">
            <label for="tiempo_entrega">Tiempo de Entrega (días)</label>
            <input type="number" name="tiempo_entrega" class="form-control" value="{{ $presupuesto->tiempo_entrega }}" required>
        </div>
        <div class="form-group">
            <label for="validez">Validez</label>
            <input type="date" name="validez" class="form-control" value="{{ $presupuesto->validez }}" required>
        </div>
        <button type="submit" class="btn btn-success">Actualizar</button>
    </form>
</body>
</html>