<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Presupuesto</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
</head>
<body>
    @include('menu')

    <div class="card">
        <div class="card-body">
            <form action="{{ route('factura.carga') }}" method="POST">
                @csrf <!-- Protección contra CSRF -->

                <div class="container mt-5">
                    <input type="hidden" class="form-control" id="user_id" name="user_id" value="{{ session('user_id'); }}" readonly>

                    @foreach($empresas as $empresa)
                        <h3>Formulario de Presupuesto: {{ $empresa->razon_social }}</h3>
                        <input type="hidden" id="empresa_id" name="empresa_id" value="{{ $empresa->id }}">
                    @endforeach

                    <div class="form-group">
                        <label for="correlativo">Correlativo:</label>
                        <input type="text" class="form-control" id="correlativo" name="correlativo" value="{{ $correlativo }}" readonly>
                    </div>

                    {{-- Obtener el ID de la empresa actual de la colección $empresas --}}
                    @php
                        $currentEmpresaId = $empresas->isNotEmpty() ? $empresas->first()->id : null;
                    @endphp

                    <!-- NUEVA SECCIÓN: Mostrar el Porcentaje de Inventario solo para EMPRESA != 1 -->
                    @if ($currentEmpresaId && $currentEmpresaId != 1)
                        <div class="form-group">
                            <label for="porcentaje_inventario">Porcentaje de Inventario (Aplicado a Precio Base):</label>
                            <!-- Campo visible solo para Empresa != 1 -->
                            <input type="text" class="form-control" value="{{ $porcentaje ? $porcentaje->porcentaje  : '0%' }}" readonly>
                        </div>
                        <!-- Campo oculto con el valor dinámico para Empresa != 1 -->
                        <input type="hidden" id="valor_porcentaje_inventario" name="porcentaje_aplicado" value="{{ $porcentaje ? $porcentaje->porcentaje : 0 }}">
                    @else
                        <!-- Campo oculto con valor 0 para Empresa 1 (para que JS no falle y se envíe 0) -->
                        <input type="hidden" id="valor_porcentaje_inventario" name="porcentaje_aplicado" value="0">
                    @endif
                    <!-- FIN NUEVA SECCIÓN -->

                    <div class="form-group">
                        <label for="cliente_id">Selecciona un cliente:</label>
                        <select class="form-control" id="cliente_id" name="cliente_id"  required>
                            <option value="">Seleccione un cliente</option>
                            @foreach($clientes as $cliente)
                                <option value="{{ $cliente->id }}">{{ $cliente->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="descripcion">Selecciona productos:</label>
                        <select class="form-control" id="descripcion" name="descripcion[]" multiple required>
                            <option value="">Seleccione productos</option>
                        </select>
                    </div>

                    <div id="producto_cantidades" class="mb-3"></div> <!-- Contenedor para las cantidades -->

                    <div class="form-group">
                        <label for="subtotal">Subtotal:</label>
                        <input type="number" class="form-control" id="subtotal" name="subtotal" step="0.01" required readonly>
                    </div>

                    <div class="form-group">
                        <label for="iva">IVA (%):</label>
                        <input type="number" class="form-control" id="iva" name="iva" step="0.01" value="{{ $iva }}" readonly>
                    </div>

                    <div class="form-group">
                        <label for="descuento">Descuento (%):</label>
                        <input type="number" class="form-control" id="descuento" name="descuento" step="0.01" value="0" oninput="calcularTotales()">
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
                <input type="text" class="form-control" id="condiciones_pago" name="condiciones_pago" onkeyup="this.value = this.value.toUpperCase();" required>
                    </div>

                    <button type="submit" class="btn btn-success btn-block">Enviar</button>
                </div>
            </form>
        </div>
    </div>

<!-- Enlace a Bootstrap JS y dependencias -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<script>
$(document).ready(function() {
    $('#descripcion').select2({
        placeholder: "Selecciona productos",
        allowClear: true,
        ajax: {
            url: '/api/productos', // Cambia esta URL a tu endpoint
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params.term, // Término de búsqueda
                    page: params.page || 1 // Página actual para paginación
                };
            },
            processResults: function (data, params) {
                params.page = params.page || 1;

                return {
                    results: data.items.map(item => ({
                        id: item.id,
                        text: `${item.codigo} - ${item.descripcion}`,
                        precio_unitario: item.precio_unitario // Asegúrate de que tu respuesta tenga esta estructura
                    })),
                    pagination: {
                        more: data.pagination.has_more // Indica si hay más resultados
                    }
                };
            },
            cache: false
        },
        minimumInputLength: 1, // Mínimo de caracteres para iniciar la búsqueda
        language: {
            inputTooShort: function () {
                //return "Introduce más caracteres"; // Mensaje en español
	            return	"Por favor, introduzca el nombre, código o descripción del producto.";
            },
            // Puedes añadir otros mensajes en español si lo deseas
        }
    });

    // Al cambiar la selección de productos
    $('#descripcion').on('change', function() {
        const selectedOptions = $(this).val();
        const container = $('#producto_cantidades');

        // Limpiar el contenedor antes de agregar nuevos campos
        container.empty();
        if (selectedOptions) {
            selectedOptions.forEach(function(productId) {
                $.ajax({
                    url: '/api/productos/' + productId, // Cambia esta URL a tu endpoint para obtener detalles del producto
                    method: 'GET',
                    dataType: 'json',
                    success: function(product) {
                        let productPrice = product.precio_unitario;
                        let productDescription = product.descripcion;
                        let productCode = product.codigo;

                        // Ajuste del precio según el ID de la empresa
                        let empresa_id = document.getElementById('empresa_id').value;

                        // **Opcional: Si el porcentaje de inventario debe aplicarse aquí, descomenta y ajusta esta lógica**
                        // const porcentajeInventario = parseFloat(document.getElementById('valor_porcentaje_inventario').value) || 0;
                        // const factorPorcentaje = (100 + porcentajeInventario) / 100;
                        // productPrice *= factorPorcentaje;

                        if (empresa_id != 1) {
                           // productPrice /= 0.57; // Ajusta el precio si es necesario

                            // OJO: Esta era la línea codificada que reemplazaremos.
                            // productPrice /= 0.45; // Ajusta el precio si es necesario

                            // Obtener el valor del porcentaje dinámico
                            const porcentajeInventarioValue = parseFloat(document.getElementById('valor_porcentaje_inventario').value) || 1;

                            // Convertir el valor a decimal (e.g., 45 -> 0.45) para usarlo en la división.
                            const factorPorcentaje = porcentajeInventarioValue ;

                            // NUEVA LÓGICA: Usar el porcentaje dinámico como divisor (SOLO PARA EMPRESA != 1)
                            if (factorPorcentaje !== 0) {
                                productPrice /= factorPorcentaje;
                            } else {
                                // En caso de que el porcentaje sea 0 (para evitar división por cero), no aplicamos ajuste.
                                console.error("Error: El porcentaje de inventario es cero (0), se usará precio base.");
                            }

                        } else {
                            // Lógica para EMPRESA 1 (No se aplica el porcentaje)
                            productPrice /= 1;
                        }

                        // Asegurarse de que el precio tenga solo dos decimales
                        productPrice = productPrice.toFixed(2);
                        const cantidadInputId = `cantidad_${productId}`;

                        // Crear el campo de cantidad vacío
                        container.append(`
                            <div class="form-group row" id="producto_${productId}">
                                <label class="col-sm-8 col-form-label">${productCode} - ${productDescription}</label>
                                <div class="col-sm-4">
                                    <label for="${cantidadInputId}" class="sr-only">Cantidad:</label>
                                    <input type="number" class="form-control" id="${cantidadInputId}" name="cantidad[${productId}]" min="0" required oninput="calcularTotales()">
                                    <small class="precio-producto" data-precio="${productPrice}">Precio: $${productPrice}</small>
                                </div>
                            </div>
                        `);
                    }
                });
            });
        }
    });

    // Calcular totales al cambiar las cantidades
    $('#producto_cantidades').on('input', 'input[type="number"]', function() {
        calcularTotales();
    });
});

function calcularTotales() {
    let subtotal = 0;
    const selectedProducts = $('#descripcion').val();
    const empresa_id = document.getElementById('empresa_id').value;

    if (selectedProducts) {
        selectedProducts.forEach(function(productId) {
            const cantidad = parseInt($(`#cantidad_${productId}`).val()) || 0;
            const productPrice = parseFloat($(`#producto_${productId} .precio-producto`).data('precio')) || 0;

            // Ajuste del precio según el ID de la empresa - ESTA LÓGICA DE PRECIO YA SE HIZO EN EL 'change' handler
            // y está guardada en el atributo data-precio. Aquí solo se usa para calcular el subtotal.
            let precioFinal = productPrice;

            // Depuración
            console.log(`Producto ID: ${productId}, Cantidad: ${cantidad}, Precio: ${productPrice}, Precio Final: ${precioFinal}`);

            // Acumular el subtotal
            subtotal += cantidad * precioFinal; // Acumular el subtotal
        });
    }

    const iva = parseFloat($('#iva').val()) || 0;
    const descuento = parseFloat($('#descuento').val()) || 0;

    // Calcular el subtotal con descuento
    const subtotalConDescuento = subtotal - (subtotal * descuento / 100);
    // Calcular el total incluyendo IVA
    const total = subtotalConDescuento + (subtotalConDescuento * iva / 100);

    // Actualizar los campos de subtotal y total
    $('#subtotal').val(subtotal.toFixed(2));
    $('#total').val(total.toFixed(2)); // Total incluyendo IVA
}
</script>

</body>
</html>
