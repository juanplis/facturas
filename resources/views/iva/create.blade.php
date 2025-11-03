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
    </style>
</head>
<body>
    <div class="container mt-5">
   <!--  /* @extends('layouts.app') */ -->

@section('content')
    <h1>Crear Nuevo IVA</h1>
    <form action="{{ route('iva.store') }}" method="POST">
        @csrf
        <div>
            <label for="monto_iva">Monto IVA:</label>
            <input type="text" name="monto_iva" id="monto_iva" required>
        </div>
        <div>
            <label for="monto_iva">Fecha:</label>
            <input type="date" name="fecha" id="fecha" required>
        </div>
        <div>
            <label for="estatus">Estatus:</label>
            <input type="number" name="estatus" id="estatus" value="1" required>
        </div>
        <button type="submit">Crear IVA</button>
    </form>
@endsection


</div>
</body>


        </table>
    </div>
</body>
</html>

