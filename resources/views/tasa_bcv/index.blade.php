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
    <title>Tasa BCV</title>
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
    <h3>Lista de Tasas BCV</h3>
     <form action="{{ route('tasa_bcv.index') }}" method="GET" class="mb-3">
       
       <a href="{{ route('tasa_bcv.create') }}" class="btn btn-primary mb-3">Crear Nueva Tasa BCV</a>
       
<!--input type="text" name="search" class="form-control" placeholder="Buscar por fecha o monto..." value="{{ request('search') }}" -->

       
        <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Buscar por fecha o monto..." value="{{ request('search') }}">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit">Buscar</button>
                </div>
            </div>
       
        <table class="table table-bordered">
            <thead class="thead-light">
                <tr>
                 <th>N°</th>
                 <th>Fecha</th>
                 <th>Monto BCV</th>
                 <th>Monto Euro</th>
                 <th>Intervenciones</th>
                 <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tasa_bcvs as $tasa)
                <tr>
                    <td>{{ $tasa->id }}</td>
                    <td>{{ $tasa->fecha_bcv }}</td>
                    <td>{{ $tasa->monto_bcv }}</td>
                    <td>{{ $tasa->monto_bcv_euro }}</td>
                    <td>{{ $tasa->intervenciones }}</td>
                    <!--td>
                        <a href="{{ route('tasa_bcv.edit', $tasa->id) }}">Editar</a>
                        <form action="{{ route('tasa_bcv.destroy', $tasa->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Eliminar</button>
                        </form>
                    </td-->
                    <td>
                        <div class="btn-group" role="group" aria-label="Acciones">
                            <a href="{{ route('tasa_bcv.edit', $tasa->id) }}" class="btn btn-primary">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                            <form action="{{ route('tasa_bcv.destroy', $tasa->id) }}" method="POST" style="display:inline;" class="delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger delete-button" data-id="{{ $tasa->id }}">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                  
                  
                  
                </tr>
            @endforeach
        </tbody>
    </table>
               </form>

</div>
</body>
</html>
