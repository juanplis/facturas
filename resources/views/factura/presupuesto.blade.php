<!DOCT<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Presupuestos</title>
    <!-- Enlace a Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Enlace a Select2 CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
</head>
<body>
    @include('menu')

    <div class="container mt-5">
        <h1 class="text-center">Formulario de Presupuestos</h1>
        <div class="card">
            <div class="card-body">

                <form action="{{ route ('factura.carga') }}" method="POST">

                    @csrf <!-- Protección contra CSRF -->
                    <div class="form-group">
                        <label for="cliente_id">Selecciona un cliente:</label>
                        <select class="form-control" id="cliente_id" name="cliente_id" required>
                            <option value="">Seleccione un cliente</option>
                            @foreach($clientes as $cliente)
                                <option value="{{ $cliente->id}}">{{ $cliente->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="descripcion">Selecciona productos:</label>
                        <select class="form-control" id="descripcion" name="descripcion[]" multiple required>
                            <option value="">Seleccione productos</option>
                            @foreach($inventarios as $inventario)
                                <option value="{{ $inventario->id }}" data-precio="{{ $inventario->precio_unitario }}" data-descripcion="{{ $inventario->descripcion }}">{{ $inventario->descripcion }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div id="producto_cantidades" class="mb-3"></div> <!-- Contenedor para las cantidades -->


                    <div class="form-group">
                        <label for="subtotal">Subtotal:</label>
                        <input type="number" class="form-control" id="subtotal" name="subtotal" step="0.01" required readonly>
                    </div>

                    <div class="form-group">
                        <label for="total">Total:</label>
                        <input type="number" class="form-control" id="total" name="total" step="0.01" required readonly>
                    </div>

                    <div class="form-group">
                        <label for="fecha">Fecha:</label>
                        <input type="date" class="form-control" id="fecha" name="fecha" required>
                    </div>


                    <div class="form-group">
                        <label for="validez">Validez:</label>
                        <input type="date" class="form-control" id="validez" name="validez" required>
                    </div>


                    <div class="form-group">
                        <label for="condiciones_pago">Condiciones de Pago:</label>
                        <input type="text" class="form-control" id="condiciones_pago" name="condiciones_pago" required>
                    </div>


                    <button type="submit" class="btn btn-success btn-block">Enviar</button>
                </form>
            </div>
        </div>
    </div>
    <!-- Enlace a Bootstrap JS y dependencias -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Enlace a Select2 JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#descripcion').select2({
            placeholder: "Selecciona productos",
            allowClear: true
        });

        // Manejar la selección de productos y agregar campos de cantidad
        $('#descripcion').on('change', function() {
            const selectedOptions = $(this).val();
            const container = $('#producto_cantidades');
            container.empty(); // Limpiar contenedor antes de agregar nuevos campos

            selectedOptions.forEach(function(productId) {
                const productDescription = $('#descripcion option[value=' + productId + ']').data('descripcion');
                const productPrice = $('#descripcion option[value=' + productId + ']').data('precio');
                container.append(`
                    <div class="form-group">
                        <label for="cantidad_${productId}">Cantidad del producto ${productDescription}:</label>
                        <input type="number" class="form-control" id="cantidad_${productId}" name="cantidad[${productId}]" min="1" required oninput="calcularTotales()">
                        <small>Precio: $${productPrice}</small>
                    </div>
                `);
            });
        });
    });

    function calcularTotales() {
        let subtotal = 0;
        const selectedProducts = $('#descripcion').val();

        selectedProducts.forEach(function(productId) {
            const cantidad = parseInt($(`#cantidad_${productId}`).val()) || 0;
            const precio = parseFloat($(`#descripcion option[value=${productId}]`).data('precio')) || 0;
            subtotal += cantidad * precio;
        });

        $('#subtotal').val(subtotal.toFixed(2));
        $('#total').val(subtotal.toFixed(2)); // Total sin impuestos por ahora
    }
    </script>
</body>
</html>
