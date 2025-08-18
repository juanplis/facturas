<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Presupuesto</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
</head>
<body>
    @include('menu')

    <div class="container mt-5">
        <h1 class="text-center">Editar Presupuesto</h1>
        <div class="card">
            <div class="card-body">

                <form action="{{ route('factura.update', $presupuesto->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="cliente_id">Selecciona un cliente:</label>
                        <select class="form-control" id="cliente_id" name="cliente_id" required>
                            <option value="">Seleccione un cliente</option>
                            @foreach($clientes as $cliente)
                                <option value="{{ $cliente->id }}" {{ $presupuesto->cliente_id == $cliente->id ? 'selected' : '' }}>{{ $cliente->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="descripcion">Selecciona productos:</label>
                        <select name="descripcion[]" id="producto_id" class="form-control" multiple required>
                            @foreach($productos as $producto)
                                <option value="{{ $producto->id }}" data-precio="{{ $producto->precio_unitario }}" data-descripcion="{{ $producto->descripcion }}" {{ in_array($producto->id, $presupuesto->items->pluck('codigo')->toArray()) ? 'selected' : '' }}>
                                    {{ $producto->descripcion }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div id="producto_cantidades" class="mb-3">
                        @foreach($presupuesto->items as $item)
                            <div class="form-group">
                                <label for="cantidad_{{ $item->codigo }}">Cantidad del producto {{ $item->descripcion }}:</label>
                                <input type="number" class="form-control" id="cantidad_{{ $item->codigo }}" name="cantidad[{{ $item->codigo }}]" min="1" value="{{ $item->cantidad }}" required oninput="calcularTotales()">
                                <small>Precio: ${{ $item->precio_unitario }}</small>
                            </div>
                        @endforeach
                    </div>

                    <div class="form-group">
                        <label for="subtotal">Subtotal:</label>
                        <input type="number" class="form-control" id="subtotal" name="subtotal" step="0.01" value="{{ $presupuesto->subtotal }}" required readonly>
                    </div>

                    <div class="form-group">
                        <label for="total">Total:</label>
                        <input type="number" class="form-control" id="total" name="total" step="0.01" value="{{ $presupuesto->total }}" required readonly>
                    </div>

                    <div class="form-group">
                        <label for="fecha">Fecha:</label>
                        <input type="date" class="form-control" id="fecha" name="fecha" value="{{ $presupuesto->fecha }}" required>
                    </div>

                    <div class="form-group">
                        <label for="validez">Validez:</label>
                        <input type="date" class="form-control" id="validez" name="validez" value="{{ $presupuesto->validez }}" required>
                    </div>

                    <div class="form-group">
                        <label for="condiciones_pago">Condiciones de Pago:</label>
                        <input type="text" class="form-control" id="condiciones_pago" name="condiciones_pago" value="{{ $presupuesto->condiciones_pago }}" required>
                    </div>

                    <input type="hidden" name="empresa_id" value="{{ $presupuesto->empresa_id }}"> <!-- Campo oculto para empresa_id -->

                    <button type="submit" class="btn btn-success btn-block">Actualizar</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#producto_id').select2({
            placeholder: "Selecciona productos",
            allowClear: true
        });
    });

    function calcularTotales() {
        let subtotal = 0;
        const selectedProducts = $('#producto_id').val();

        selectedProducts.forEach(function(productId) {
            const cantidad = parseInt($(`#cantidad_${productId}`).val()) || 0;
            const precio = parseFloat($(`#producto_id option[value=${productId}]`).data('precio')) || 0;
            subtotal += cantidad * precio;
        });

        $('#subtotal').val(subtotal.toFixed(2));
        $('#total').val(subtotal.toFixed(2)); // Total sin impuestos por ahora
    }
    </script>
</body>
</html>
