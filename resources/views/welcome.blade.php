<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Presupuestos</title>
    <!-- Enlace a Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Formulario de Presupuestos</h1>
        <div class="card">
            <div class="card-body">
                <form action="tu_ruta_de_procesamiento" method="POST">
                    <div class="form-group">
                        <label for="id">ID:</label>
                        <input type="text" class="form-control" id="id" name="id" required>
                    </div>

                    <!--<div class="form-group">
                        <label for="cliente_id">Cliente ID:</label>
                        <input type="text" class="form-control" id="cliente_id" name="cliente_id" required>
                    </div>-->

                    <div class="form-group">
                        <label for="fecha">Fecha:</label>
                        <input type="date" class="form-control" id="fecha" name="fecha" required>
                    </div>

                    <div class="form-group">
                        <label for="subtotal">Subtotal:</label>
                        <input type="number" class="form-control" id="subtotal" name="subtotal" step="0.01" required>
                    </div>

                      <!-- <div class="form-group">
                        <label for="iva">IVA:</label>
                        <input type="number" class="form-control" id="iva" name="iva" step="0.01" required>
                    </div>-->


                    <div class="form-group">
                        <label for="total">Total:</label>
                        <input type="number" class="form-control" id="total" name="total" step="0.01" required>
                    </div>

                    <div class="form-group">
                        <label for="condiciones_pago">Condiciones de Pago:</label>
                        <input type="text" class="form-control" id="condiciones_pago" name="condiciones_pago" required>
                    </div>

                    <!--<div class="form-group">
                        <label for="tiempo_entrega">Tiempo de Entrega:</label>
                        <input type="text" class="form-control" id="tiempo_entrega" name="tiempo_entrega" required>
                    </div>-->

                    <div class="form-group">
                        <label for="validez">Validez:</label>
                        <input type="date" class="form-control" id="validez" name="validez" required>
                    </div>

                    <button type="submit" class="btn btn-primary btn-block">Enviar</button>
                </form>
            </div>
        </div>
    </div>
    <!-- Enlace a Bootstrap JS y dependencias -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
