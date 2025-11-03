<!DOCTYPE html>
<html lang="es">
<head>
    <!-- Enlace a Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Enlace a Select2 CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <!-- Enlace a Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    @include('menu')
    <title>Clientes</title>
    <style>
        /* Estilo para filas alternas */
        tbody tr:nth-child(odd) {
            background-color: #f8f9fa; /* Color gris claro */
        }
        tbody tr:nth-child(even) {
            background-color: #ffffff; /* Color blanco */
        }
        .form-group label {
            font-weight: bold;
        }
        .btn-custom {
            background-color: #007bff;
            color: white;
        }
    </style>
</head>
<body>

    <div class="container mt-5">
              <h3 class="mb-4">Editar Producto: {{ $inventario->nombre }}</h3>
				<form action="{{ route('inventario.update', $inventario->id) }}" method="POST">
                
                    @csrf
                    @method('PUT') <!-- Método PUT para actualización -->

                    <div class="form-group">
                        <label for="codigo">Código:</label>
                        <input type="text" class="form-control" id="codigo" name="codigo" value="{{ old('codigo', $inventario->codigo) }}" required>
                    </div>

                   <div class="form-group">
                        <label for="descripcion">Descripción:</label>
                        <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required>{{ old('descripcion', $inventario->descripcion) }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="precio_unitario">Precio Unitario:</label>
                        <input type="number" step="0.01" class="form-control" id="precio_unitario" name="precio_unitario" value="{{ old('precio_unitario', $inventario->precio_unitario) }}">
                    </div>

                    <div class="form-group">
                        <label for="concepto_general">Concepto General:</label>
                        <input type="text" class="form-control" id="concepto_general" name="concepto_general" value="{{ old('concepto_general', $inventario->concepto_general) }}">
                    </div>

                    <div class="form-group">
                        <label for="version">Versión:</label>
                        <input type="text" class="form-control" id="version" name="version" value="{{ old('version', $inventario->version) }}">
                    </div>

                    <div class="form-group">
                        <label for="dimensiones">Dimensiones:</label>
                        <input type="text" class="form-control" id="dimensiones" name="dimensiones" value="{{ old('dimensiones', $inventario->dimensiones) }}">
                    </div>

                    <div class="form-group">
                        <label for="detalles">Detalles:</label>
                        <textarea class="form-control" id="detalles" name="detalles" rows="3">{{ old('detalles', $inventario->detalles) }}</textarea>
                    </div>

                    <button type="submit"  class="btn btn-custom">
                         Actualizar 
                    </button>
                    <!--a href="{{ route('inventario.index') }}" class="btn btn-secondary ml-2">
                        <i class="fas fa-arrow-left"></i> Volver al Inventario
                    </a-->
                </form>
            </div>
         <!-- Enlace a jQuery y Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>