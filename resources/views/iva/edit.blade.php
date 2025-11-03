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
<div class="container mx-auto px-4 py-8 max-w-2xl">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Editar Iva:</h1>

    <form action="{{ route('iva.update', $iva) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Razón Social -->
        <div class="md:col-span-2">
            <label for="monto_iva" class="block text-sm font-medium text-gray-700">Monto Iva: *</label>
            <input type="text" name="monto_iva" id="monto_iva"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                    value="{{ $iva->monto_iva }}" required>
                @error('monto_iva')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
        </div>
		<div class="md:col-span-2">
            <label for="fecha" class="block text-sm font-medium text-gray-700">Fecha: *</label>
            <input type="date" name="fecha" id="fecha"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                    value="{{ $iva->fecha }}" required>
                @error('fecha')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
        </div>

        <!-- Estatus -->
            <div>
                <label for="estatus" class="block text-sm font-medium text-gray-700">Estatus</label>
                <select name="estatus" id="estatus"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    <option value="1" {{ $iva->estatus == '1' ? 'selected' : '' }}>Activo</option>
                    <option value="0" {{ $iva->estatus == '0' ? 'selected' : '' }}>Inactivo</option>
                </select>
            </div>
            <!-- Fecha de Registro -->

        <div class="mt-8 flex justify-end space-x-3">
            <a href="{{ route('iva.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-md">
                Cancelar
            </a>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M7.707 10.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l6-6a1 1 0 10-1.414-1.414L10 12.586l-2.293-2.293z" />
                </svg>
                Actualizar IVA
            </button>
        </div>
    </form>
</div>
@endsection


</div>
</body>


        </table>
    </div>
</body>
</html>
