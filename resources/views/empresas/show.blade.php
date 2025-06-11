@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-3xl">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Detalles de Empresa</h1>
        <div class="flex space-x-2">
            <a href="{{ route('empresas.edit', $empresa->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-md flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                </svg>
                Editar
            </a>
            <a href="{{ route('empresas.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-md flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                Volver
            </a>
        </div>
    </div>

    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <h2 class="text-xl font-semibold text-gray-700 mb-4">Información General</h2>

                    <div class="space-y-4">
                        <div>
                            <h3 class="text-sm font-medium text-gray-500">Razón Social</h3>
                            <p class="mt-1 text-lg text-gray-900">{{ $empresa->razon_social }}</p>
                        </div>

                        <div>
                            <h3 class="text-sm font-medium text-gray-500">RIF</h3>
                            <p class="mt-1 text-lg text-gray-900">{{ $empresa->rif }}</p>
                        </div>

                        <div>
                            <h3 class="text-sm font-medium text-gray-500">Teléfono</h3>
                            <p class="mt-1 text-lg text-gray-900">{{ $empresa->telefono }}</p>
                        </div>
                    </div>
                </div>

                <div>
                    <h2 class="text-xl font-semibold text-gray-700 mb-4">Datos Adicionales</h2>

                    <div class="space-y-4">
                        <div>
                            <h3 class="text-sm font-medium text-gray-500">Estatus</h3>
                            <span class="mt-1 px-3 py-1 inline-flex text-sm font-semibold rounded-full {{ $empresa->estatus == 'activo' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ ucfirst($empresa->estatus) }}
                            </span>
                        </div>

                        <div>
                            <h3 class="text-sm font-medium text-gray-500">Fecha de Registro</h3>
                            <p class="mt-1 text-lg text-gray-900">{{ $empresa->fecha_registro->format('d/m/Y') }}</p>
                        </div>

                        <div>
                            <h3 class="text-sm font-medium text-gray-500">Fecha de Creación</h3>
                            <p class="mt-1 text-lg text-gray-900">{{ $empresa->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
