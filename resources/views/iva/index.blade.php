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
    <title>Iva</title>
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
           <form action="{{ route('iva.index') }}" method="GET" class="mb-3">

<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-6">
        <h3  class="text-3xl font-bold text-gray-800">Gestión de Iva</h3>
        <a href="{{ route('iva.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
            </svg>
            Nuevo IVA
        </a>
    </div>
      <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Buscar por fecha o monto..." value="{{ request('search') }}">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit">Buscar</button>
                </div>
            </div>
    @if(session('success'))
        <div>{{ session('success') }}</div>
    @endif
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">N°</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Monto Iva</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estatus</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">

                  @foreach ($iva as $iva)
            <tr>
              
                <td class="px-6 py-4 whitespace-nowrap">{{ $iva->id }} </td>
                <td class="px-6 py-4 whitespace-nowrap">{{ $iva->monto_iva }} </td>
                <td class="px-6 py-4 whitespace-nowrap">{{ $iva->fecha }} </td>

                <!--td class="px-6 py-4 whitespace-nowrap">{{ $iva->estatus }}</td-->
                <!--td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $iva->estatus == 'activo' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ ucfirst($iva->estatus) }}
                        </span>
                </td-->
                
                <!--td class="px-6 py-4 whitespace-nowrap">
                <a href="{{ route('iva.edit', $iva) }}">Editar</a>

                    <form action="{{ route('iva.destroy', $iva) }}" method="POST" style="display:inline;">

                    @csrf
                    @method('DELETE')
                    <button type="submit">Eliminar</button>
                </form>
                </td-->
              
              
              <td class="px-6 py-4 whitespace-nowrap">
                        <!--span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $iva->estatus == 'activo' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ ucfirst($iva->estatus) }}
                        </span-->
                      
                      @if(isset($iva) && $iva->estatus)
                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $iva->estatus == '1' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                   Activa
                </span>
           			 @else
                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                   Inactiva
                </span>
           			 @endif

                      
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        <div class="flex space-x-2">
                          
                            <a href="{{ route('iva.edit', $iva->id) }}" class="btn btn-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                                </svg>
                            </a>
                        <!--/div>
                      
                      
                         <div class="flex space-x-2"-->

                            <form action="{{ route('iva.destroy', $iva) }}" method="POST" style="display:inline;" class="delete-form">
                                  @csrf
                                  @method('DELETE')

                                   <button type="submit" class="btn btn-danger delete-button" data-id="{{ $iva }}">
                                          <i class="fas fa-trash-alt"></i>
                                      </button>
                              </form>
                          </div>
                      
                    </td>
              
              
        @endforeach
    </tr>
@endsection

 
        </table>
    </div>
  </div>
</body>
</html>
