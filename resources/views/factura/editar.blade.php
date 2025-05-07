<!DOCTYPE html>
<html lang="es">
    @include('menu')
    <h1>Editar Presupuesto</h1>
    <form action="{{ route('facturas.index', $presupuesto->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="cliente_id">Cliente ID</label>
            <input type="number" name="cliente_id" class="form-control" value="{{ $factura->cliente_id }}" required>
        </div>
        <div class="form-group">
            <label for="fecha">Fecha</label>
            <input type="date" name="fecha" class="form-control" value="{{ $factura->fecha }}" required>
        </div>
        <div class="form-group">
            <label for="subtotal">Subtotal</label>
            <input type="number" step="0.01" name="subtotal" class="form-control" value="{{ $factura->subtotal }}" required>
        </div>
        <div class="form-group">
            <label for="iva">IVA</label>
            <input type="number" step="0.01" name="iva" class="form-control" value="{{ $factura->iva }}" required>
        </div>
        <div class="form-group">
            <label for="total">Total</label>
            <input type="number" step="0.01" name="total" class="form-control" value="{{ $factura->total }}" required>
        </div>
        <div class="form-group">
            <label for="condiciones_pago">Condiciones de Pago</label>
            <input type="text" name="condiciones_pago" class="form-control" value="{{ $factura->condiciones_pago }}" required>
        </div>
        <div class="form-group">
            <label for="tiempo_entrega">Tiempo de Entrega (días)</label>
            <input type="number" name="tiempo_entrega" class="form-control" value="{{ $factura->tiempo_entrega }}" required>
        </div>
        <div class="form-group">
            <label for="validez">Validez</label>
            <input type="date" name="validez" class="form-control" value="{{ $factura->validez }}" required>
        </div>
        <button type="submit" class="btn btn-success">Actualizar</button>
    </form>
</body>
</html>