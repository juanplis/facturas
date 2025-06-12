<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    @include('menu') {{-- Asumo que tienes un archivo 'menu.blade.php' --}}
    <title>Editar Producto de Inventario</title>
</head>
<body>
    <div class="container mt-5">
        <h1>Editar Producto</h1>

        {{-- Formulario para la edición del producto --}}
        {{-- action apunta a la ruta 'inventario.update' y le pasa el ID del producto --}}
        {{-- method="POST" es necesario, y @method('PUT') para indicar que es una actualización --}}
        <form action="{{ route('inventario.update', $inventario->id) }}" method="POST">
            @csrf {{-- Token CSRF para protección contra ataques --}}
            @method('PUT') {{-- Directiva para indicar que esta es una solicitud PUT para actualización --}}

            <div class="form-group">
                <label for="codigo">Código:</label>
                <input type="text" class="form-control @error('codigo') is-invalid @enderror" id="codigo" name="codigo" value="{{ old('codigo', $inventario->codigo) }}" required>
                @error('codigo')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="descripcion">Descripción:</label>
                <input type="text" class="form-control @error('descripcion') is-invalid @enderror" id="descripcion" name="descripcion" value="{{ old('descripcion', $inventario->descripcion) }}" required>
                @error('descripcion')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="precio_unitario">Precio Steel:</label>
                <input type="number" step="0.01" class="form-control @error('precio_unitario') is-invalid @enderror" id="precio_unitario" name="precio_unitario" value="{{ old('precio_unitario', $inventario->precio_unitario) }}" required>
                @error('precio_unitario')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="precio_cocina">Precio Tu Cocina:</label>
                <input type="number" step="0.01" class="form-control @error('precio_cocina') is-invalid @enderror" id="precio_cocina" name="precio_cocina" value="{{ old('precio_cocina', $inventario->precio_cocina) }}" required>
                @error('precio_cocina')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="costo">Costo:</label>
                <input type="number" step="0.01" class="form-control @error('costo') is-invalid @enderror" id="costo" name="costo" value="{{ old('costo', $inventario->costo) }}" required>
                @error('costo')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="concepto_general">Concepto General:</label>
                <input type="text" class="form-control @error('concepto_general') is-invalid @enderror" id="concepto_general" name="concepto_general" value="{{ old('concepto_general', $inventario->concepto_general) }}">
                @error('concepto_general')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="version">Versión:</label>
                <input type="text" class="form-control @error('version') is-invalid @enderror" id="version" name="version" value="{{ old('version', $inventario->version) }}">
                @error('version')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="dimensiones">Dimensiones:</label>
                <input type="text" class="form-control @error('dimensiones') is-invalid @enderror" id="dimensiones" name="dimensiones" value="{{ old('dimensiones', $inventario->dimensiones) }}">
                @error('dimensiones')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="detalles">Detalles:</label>
                <textarea class="form-control @error('detalles') is-invalid @enderror" id="detalles" name="detalles" rows="3">{{ old('detalles', $inventario->detalles) }}</textarea>
                @error('detalles')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Actualizar Producto</button>
            <a href="{{ route('inventario.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>

    {{-- Scripts JS --}}
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
</body>
</html>