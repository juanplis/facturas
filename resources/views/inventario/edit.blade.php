<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Presupuesto</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    @include('menu')

    <div class="card">
        <div class="card-body">
            <form action="{{ route('factura.update', $presupuesto->id) }}" method="POST">
                @csrf
                @method('PUT') <!-- Método PUT para actualización -->

                <div class="container mt-5">
                    <h1 class="text-center">Editar Presupuesto: {{ $presupuesto->empresa->razon_social }}</h1>
                    <input type="hidden" name="empresa_id" value="{{ $presupuesto->empresa_id }}">

                    <div class="form-group">
                        <label for="cliente_id">Selecciona un cliente:</label>
                        <select class="form-control" id="cliente_id" name="cliente_id" required>
                            <option value="">Seleccione un cliente</option>
                            @foreach($clientes as $cliente)
                                <option value="{{ $cliente->id }}" {{ $cliente->id == $presupuesto->cliente_id ? 'selected' : '' }}>{{ $cliente->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div id="producto_cantidades" class="mb-3">
                        <h5>Productos:</h5>
                        <!-- Mostrar productos directamente -->
                        <div class="form-group">
                            <label for="cantidad_producto1">Cantidad del producto Producto 1:</label>
                            <input type="number" class="form-control" id="cantidad_producto1" name="cantidad[producto1]" value="2" min="1" required>
                            <small>Precio: $10.00</small>
                        </div>

                        <div class="form-group">
                            <label for="cantidad_producto2">Cantidad del producto Producto 2:</label>
                            <input type="number" class="form-control" id="cantidad_producto2" name="cantidad[producto2]" value="3" min="1" required>
                            <small>Precio: $15.00</small>
                        </div>

                        <div class="form-group">
                            <label for="cantidad_producto3">Cantidad del producto Producto 3:</label>
                            <input type="number" class="form-control" id="cantidad_producto3" name="cantidad[producto3]" value="1" min="1" required>
                            <small>Precio: $20.00</small>
                        </div>
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

                    <button type="submit" class="btn btn-success btn-block">Actualizar</button>
                </form>

                <div id="cantidades_mostradas" class="mt-4">
                    <h5>Cantidades de Productos:</h5>
                    <p id="cantidad_producto1_mostrada">Producto 1: 2</p>
                    <p id="cantidad_producto2_mostrada">Producto 2: 3</p>
                    <p id="cantidad_producto3_mostrada">Producto 3: 1</p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script>
    function mostrarCantidades() {
        // Obtener las cantidades de los inputs
        const cantidad1 = $('#cantidad_producto1').val();
        const cantidad2 = $('#cantidad_producto2').val();
        const cantidad3 = $('#cantidad_producto3').val();

        // Mostrar las cantidades en el div correspondiente
        $('#cantidad_producto1_mostrada').text(`Producto 1: ${cantidad1}`);
        $('#cantidad_producto2_mostrada').text(`Producto 2: ${cantidad2}`);
        $('#cantidad_producto3_mostrada').text(`Producto 3: ${cantidad3}`);
    }

    $(document).ready(function() {
        // Mostrar cantidades al cargar la página
        mostrarCantidades();

        // Actualizar cantidades al cambiar los inputs
        $('#cantidad_producto1, #cantidad_producto2, #cantidad_producto3').on('input', mostrarCantidades);
    });
    </script>
</body>
</html>
