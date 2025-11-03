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
        <h3>Editar Presupuesto</h3>
        <div class="card">
            <div class="card-body">
                <form action="{{ route('factura.update', $presupuesto->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="empresa_id" name="empresa_id" value="{{ $presupuesto->empresa_id }}">

                    <div class="form-group">
                        <label for="correlativo">Correlativo:</label>
                        <span class="form-control-plaintext" id="correlativo">{{ $presupuesto->correlativo }}</span>
                    </div>

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
                        <label for="producto_id">Selecciona productos (busca por código o descripción):</label>
                        <select name="descripcion[]" id="producto_id" class="form-control" multiple required>
                            @foreach($productos as $producto)
                                <option value="{{ $producto->codigo }}"
                                    data-precio="{{ $producto->precio_unitario }}"
                                    data-descripcion="{{ $producto->descripcion }}"
                                    {{ in_array($producto->codigo, $presupuesto->items->pluck('codigo')->toArray()) ? 'selected' : '' }}>
                                    {{ $producto->codigo }} - {{ $producto->descripcion }} 
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div id="producto_cantidades" class="mb-3"></div>

                    <div class="form-group">
                        <label for="subtotal">Subtotal:</label>
                        <input type="number" class="form-control" id="subtotal" name="subtotal" step="0.01" value="{{ $presupuesto->subtotal }}" required readonly>
                    </div>

                    <div class="form-group">
                        <label for="iva">IVA (%):</label>
                        <input type="number" class="form-control" id="iva" name="iva" step="0.01" value="16" oninput="calcularTotales()">
                    </div>

                    <div class="form-group">
                        <label for="descuento">Descuento (%):</label>
                        <input type="number" class="form-control" id="descuento" name="descuento" step="0.01" value="0" oninput="calcularTotales()">
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

                    <button type="submit" class="btn btn-success btn-block">Actualizar</button>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
  <script>
    // Función para dar formato a los resultados en Select2
    function formatProductResult(product) {
        if (!product.id) {
            return product.text;
        }

        const parts = product.text.split(' - ', 2); 
        const codigo = parts[0];
        const descripcion = parts.length > 1 ? parts[1] : '';

        return $('<span><strong>' + codigo + '</strong> - ' + descripcion + '</span>');
    }

    $(document).ready(function() {
        $('#producto_id').select2({
            placeholder: "Selecciona productos por código o descripción",
            allowClear: true,
            templateResult: formatProductResult
        });

        generarCamposCantidad();
        calcularTotales();

        $('#producto_id').on('change', function() {
            generarCamposCantidad();
            calcularTotales();
        });
        
        // Listener para los cambios en las cantidades
        $('#producto_cantidades').on('input', 'input[type="number"]', function() {
            calcularTotales();
        });
    });

    const presupuestoItems = @json($presupuesto->items);

    function generarCamposCantidad() {
        const selectedProductCodes = $('#producto_id').val() || [];
        const cantidadesContainer = $('#producto_cantidades');
        cantidadesContainer.empty(); 

        const empresa_id = document.getElementById('empresa_id').value;

        selectedProductCodes.forEach(function(productCode) {
            const productOption = $(`#producto_id option[value="${productCode}"]`);
            const productoDescripcion = productOption.data('descripcion');
            const productoPrecioBase = parseFloat(productOption.data('precio'));
            
            const fullText = productOption.text().trim();
            const productoCodigo = fullText.split(' - ', 1)[0]; 

            // **Lógica de Ajuste de Precio por Empresa**
            let adjustedPrice = productoPrecioBase;
            if (empresa_id != '1') {
                adjustedPrice = productoPrecioBase / 0.45;
              //adjustedPrice = productoPrecioBase / 0.57;
            }
            const adjustedPriceFormatted = adjustedPrice.toFixed(2);


            const existingItem = presupuestoItems.find(item => item.codigo === productCode);
            const cantidadValue = existingItem ? existingItem.cantidad : 1;

            const cantidadHtml = `
                <div class="form-group">
                    <label for="cantidad_${productCode}">Cantidad de ${productoCodigo} - ${productoDescripcion}:</label>
                    <input type="number" class="form-control" id="cantidad_${productCode}" 
                                name="cantidad[${productCode}]" min="1" value="${cantidadValue}" required 
                                oninput="calcularTotales()">
                    <small class="precio-ajustado" data-precio-ajustado="${adjustedPrice}">Precio: $${adjustedPriceFormatted}</small>
                </div>
            `;
            cantidadesContainer.append(cantidadHtml);
        });
    }

    function calcularTotales() {
        let subtotal = 0;
        const selectedProductCodes = $('#producto_id').val() || [];

        selectedProductCodes.forEach(function(productCode) {
            const cantidad = parseInt($(`#cantidad_${productCode}`).val()) || 0;
            
            // **CORRECCIÓN:** Obtener el precio ajustado guardado en el elemento small asociado
            const precioAjustadoElement = $(`#producto_cantidades input[id="cantidad_${productCode}"]`).siblings('.precio-ajustado');
            const precioAjustado = parseFloat(precioAjustadoElement.data('precio-ajustado')) || 0;

            // El subtotal se calcula con el precio ajustado
            subtotal += cantidad * precioAjustado; 
        });

        const iva = parseFloat($('#iva').val()) || 0;
        const descuento = parseFloat($('#descuento').val()) || 0;

        // El resto del cálculo
        const subtotalConDescuento = subtotal - (subtotal * descuento / 100);
        const total = subtotalConDescuento + (subtotalConDescuento * iva / 100);

        // Actualizar los campos
        $('#subtotal').val(subtotal.toFixed(2));
        $('#total').val(total.toFixed(2));
    }
</script>
</body>
</html>
