<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Presupuestos</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
</head>
<body>

    @csrf
    @if(isset($presupuesto))
        <input type="hidden" name="id" value="{{ $presupuesto->ID }}">
    @endif

    <div class="container mt-5">
        <h1 class="text-center">Formulario de Presupuestos</h1>
        <div class="card">
            <div class="card-body">
                <form action="{{ route('factura.cargar') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="Nombre">Selecciona un cliente:</label>
                        <select class="form-control" id="Nombre" name="Nombre" required>
                            <option value="">Seleccione un cliente</option>
                            @foreach($clientes as $cliente)
                                <option value="{{ $cliente->Nombre }}">{{ $cliente->Nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="Descripcion">Selecciona productos:</label>
                        <select class="form-control" id="Descripcion" name="Descripcion[]" multiple required>
                            <option value="">Seleccione productos</option>
                            @foreach($inventarios as $inventario)
                                <option value="{{ $inventario->ID }}" data-precio="{{ $inventario->Precio_Unitario }}" data-descripcion="{{ $inventario->Descripcion }}">{{ $inventario->Descripcion }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div id="Producto_Cantidades" class="mb-3"></div>

                    <div class="form-group">
                        <label for="Fecha">Fecha:</label>
                        <input type="date" class="form-control" id="Fecha" name="Fecha" required>
                    </div>

                    <div class="form-group">
                        <label for="Subtotal">Subtotal:</label>
                        <input type="number" class="form-control" id="Subtotal" name="Subtotal" step="0.01" required readonly>
                    </div>

                    <div class="form-group">
                        <label for="Total">Total:</label>
                        <input type="number" class="form-control" id="Total" name="Total" step="0.01" required readonly>
                    </div>

                    <div class="form-group">
                        <label for="Condiciones_Pago">Condiciones de Pago:</label>
                        <input type="text" class="form-control" id="Condiciones_Pago" name="Condiciones_Pago" required>
                    </div>
                    <div class="form-group">
                        <label for="Validez">Validez:</label>
                        <input type="date" class="form-control" id="Validez" name="Validez" required min="{{ date('Y-m-d') }}">
                    </div>

                    <button type="submit" class="btn btn-success btn-block">Enviar</button>
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
        $('#Descripcion').select2({
            placeholder: "Selecciona productos",
            allowClear: true
        });

        $('#Descripcion').on('change', function() {
            const selectedOptions = $(this).val();
            const container = $('#Producto_Cantidades');
            container.empty();

            selectedOptions.forEach(function(productId) {
                const productDescription = $('#Descripcion option[value=' + productId + ']').data('descripcion');
                const productPrice = $('#Descripcion option[value=' + productId + ']').data('precio');
                container.append(`
                    <div class="form-group">
                        <label for="cantidad_${productId}">Cantidad del producto ${productDescription}:</label>
                        <input type="number" class="form-control" id="cantidad_${productId}" name="cantidad[${productId}]" min="1" required oninput="calcularTotales()">
                        <small>Precio: $${productPrice}</small>
                        <input type="hidden" name="descripcion[${productId}]" value="${productDescription}">
                    </div>
                `);
            });
        });
    });

    function calcularTotales() {
        let subtotal = 0;
        const selectedProducts = $('#Descripcion').val();

        selectedProducts.forEach(function(productId) {
            const cantidad = parseInt($(`#cantidad_${productId}`).val()) || 0;
            const precio = parseFloat($(`#Descripcion option[value=${productId}]`).data('precio')) || 0;
            subtotal += cantidad * precio;
        });

        $('#Subtotal').val(subtotal.toFixed(2));
        $('#Total').val(subtotal.toFixed(2));
    }
    </script>
</body>
</html>
