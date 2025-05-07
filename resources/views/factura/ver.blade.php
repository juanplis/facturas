<!DOCTYPE html>
<html lang="es">
 @include('menu')
    <h1>Detalles del Presupuesto</h1>
    <p><strong>ID:</strong> {{ $factura->id }}</p>
    <p><strong>Cliente ID:</strong> {{ $factura->cliente_id }}</p>
    <p><strong>Fecha:</strong> {{ $factura->fecha }}</p>
    <p><strong>Subtotal:</strong> {{ $factura->subtotal }}</p>
    <p><strong>IVA:</strong> {{ $factura->iva }}</p>
    <p><strong>Total:</strong> {{ $factura->total }}</p>
    <p><strong>Condiciones de Pago:</strong> {{ $factura->condiciones_pago }}</p>
    <p><strong>Tiempo de Entrega:</strong> {{ $factura->tiempo_entrega }} días</p>
    <p><strong>Validez:</strong> {{ $factura->validez }}</p>
    <a href="{{ route('facturas.index') }}" class="btn btn-primary">Volver</a>
</body>
</html>