<!DOCTYPE html>
<html lang="es">
          <!-- Enlace a Bootstrap CSS -->
          <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
          <!-- Enlace a Select2 CSS -->
          <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
          @include('menu')
          <h1>Editar Presupuesto</h1>
 @include('menu')
    <h1>Detalles del Presupuesto</h1>
    <p><strong>ID:</strong> {{ $presupuesto->id }}</p>
    <p><strong>Cliente ID:</strong> {{ $presupuesto->cliente_id }}</p>
    <p><strong>Fecha:</strong> {{ $presupuesto->fecha }}</p>
    <p><strong>Subtotal:</strong> {{ $presupuesto->subtotal }}</p>
    <p><strong>IVA:</strong> {{ $presupuesto->iva }}</p>
    <p><strong>Total:</strong> {{ $presupuesto->total }}</p>
    <p><strong>Condiciones de Pago:</strong> {{ $presupuesto->condiciones_pago }}</p>
    <p><strong>Tiempo de Entrega:</strong> {{ $presupuesto->tiempo_entrega }} días</p>
    <p><strong>Validez:</strong> {{ $presupuesto->validez }}</p>
    <a href="{{ route('factura.index') }}" class="btn btn-primary">Volver</a>
</body>
</html>