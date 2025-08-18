<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Nuevo Producto</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    @include('menu')
    <style>
        .form-group label {
            font-weight: bold;
        }

        .container {
            max-width: 800px;
        }

        .card {
            border-radius: 0.5rem;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h2>Crear Nuevo Producto</h2>
            </div>
            <div class="card-body">
                {{-- Muestra errores de validación --}}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('inventario.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="codigo">Código:</label>
                        <input type="text" class="form-control" id="codigo" name="codigo" value="{{ old('codigo') }}"
                            required>
                    </div>
                    <div class="form-group">
                        <label for="descripcion">Descripción:</label>
                        <input type="text" class="form-control" id="descripcion" name="descripcion"
                            value="{{ old('descripcion') }}" required>
                    </div>
                    <div class="form-group">
                        <label for="precio_unitario">Precio Unitario:</label>
                        <input type="number" step="0.01" class="form-control" id="precio_steel" name="precio_steel"
                            value="{{ old('precio_unitario') }}">
                    </div>
                   <!-- <div class="form-group">
                        <label for="precio_tu_cocina">Precio Tu Cocina:</label>
                        <input type="number" step="0.01" class="form-control" id="precio_tu_cocina"
                            name="precio_tu_cocina" value="0">
                    </div>
                    <div class="form-group">
                        <label for="costo">Costo:</label>
                        <input type="number" step="0.01" class="form-control" id="costo" name="costo"
                            value="">
                    </div>-->
                    <div class="form-group">
                        <label for="concepto_general">Concepto General:</label>
                        <input type="text" class="form-control" id="concepto_general" name="concepto_general"
                            value="{{ old('concepto_general') }}">
                    </div>
                    <div class="form-group">
                        <label for="version">Versión:</label>
                        <input type="text" class="form-control" id="version" name="version"
                            value="{{ old('version') }}">
                    </div>
                    <div class="form-group">
                        <label for="dimensiones">Dimensiones:</label>
                        <input type="text" class="form-control" id="dimensiones" name="dimensiones"
                            value="{{ old('dimensiones') }}">
                    </div>
                    <div class="form-group">
                        <label for="detalles">Detalles:</label>
                        <textarea class="form-control" id="detalles" name="detalles"
                            rows="3">{{ old('detalles') }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> Guardar Producto
                    </button>
                    <a href="{{ route('inventario.index') }}" class="btn btn-secondary ml-2">
                        <i class="fas fa-arrow-left"></i> Volver al Inventario
                    </a>
                </form>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
