@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-2xl">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Registrar Nueva Empresa</h1>

    <form action="{{ route('empresas.store') }}" method="POST" class="bg-white shadow-md rounded-lg p-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Razón Social -->
            <div class="md:col-span-2">
                <label for="razon_social" class="block text-sm font-medium text-gray-700">Razón Social *</label>
                <input type="text" name="razon_social" id="razon_social"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                    value="{{ old('razon_social') }}" required>
                @error('razon_social')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- RIF -->
            <div>
                <label for="rif" class="block text-sm font-medium text-gray-700">RIF *</label>
                <input type="text" name="rif" id="rif"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                    value="{{ old('rif') }}" required>
                @error('rif')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Teléfono -->
            <div>
                <label for="telefono" class="block text-sm font-medium text-gray-700">Teléfono *</label>
                <input type="tel" name="telefono" id="telefono"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                    value="{{ old('telefono') }}" required>
                @error('telefono')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Estatus -->
            <div>
                <label for="estatus" class="block text-sm font-medium text-gray-700">Estatus</label>
                <select name="estatus" id="estatus"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    <option value="1" {{ old('estatus') == 'activo' ? 'selected' : '' }}>Activo</option>
                    <option value="0" {{ old('estatus') == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                </select>
            </div>

            <!-- Fecha de Registro -->
            <div>
                <label for="fecha_registro" class="block text-sm font-medium text-gray-700">Fecha de Registro *</label>
                <input type="date" name="fecha_registro" id="fecha_registro"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                    value="{{ old('fecha_registro', now()->format('Y-m-d')) }}" required>
                @error('fecha_registro')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="mt-8 flex justify-end space-x-3">
            <a href="{{ route('empresas.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-md">
                Cancelar
            </a>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
                Guardar Empresa
            </button>
        </div>
    </form>
</div>
@endsection
