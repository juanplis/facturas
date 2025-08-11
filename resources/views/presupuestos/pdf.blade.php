<!DOCTYPE html>
<html>
<head>
    <style>
        .header { margin-bottom: 20px; }
        .table { width: 100%; border-collapse: collapse; }
        .table th, .table td { border: 1px solid #000; padding: 8px; }
        .text-right { text-align: right; }
        .mb-4 { margin-bottom: 1rem; }
        .banner {
            width: 100%;
            max-height: 150px;
            object-fit: cover;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <!-- SOLUCIÓN CON BASE64 -->


    @if($presupuesto->empresa_id == 1) {{-- ¡Ahora es un objeto! --}}
 <img src="data:image/png;base64,<?php echo base64_encode(file_get_contents(public_path('storage/images/baner_steel.png'))); ?>"
         alt="Banner"
         class="banner">
    </a>

    @else
 <img src="data:image/png;base64,<?php echo base64_encode(file_get_contents(public_path('storage/images/banner_tu_cocina.png'))); ?>"
         alt="Banner"
         class="banner">
    @endif

   <table border="0">
            <tr>
                <th></th>
                <td>{{$descripcion}}</td>

            </tr>
    </table>
   <table border="0">
            <tr>
                <th>{{$direccion}}</th>
                <td> <p class="text-right">PRESUPUESTO: COT{{ str_pad($presupuesto->id, 5, '0', STR_PAD_LEFT) }}</p>

                  <p class="text-right"> CODIGO CLIENTE: {{ $presupuesto->cliente->id }}</p>
                </td>
            </tr>
    </table>


    <div class="header">
        <p></p>
        <!--p class="text-right">PRESUPUESTO: COT{{ str_pad($presupuesto->id, 5, '0', STR_PAD_LEFT) }}</p>
        <p class="text-right"> CODIGO CLIENTE: {{ $presupuesto->cliente->id }}</p-->
        <p>CLIENTE: {{ $presupuesto->cliente->nombre }}</p>
        <p class="text-right">N° RIF: {{ $presupuesto->cliente->rif }}</p>


        <p>DIRECCIÓN: {{ $presupuesto->cliente->direccion }}</p>
        <p>CONTACTO: {{ $presupuesto->contactos->nombre }}</p>
        <p  class="text-right">TELEFONO: {{ $presupuesto->contactos->telefono }}</p>
        <p>CORREO: {{ $presupuesto->contactos->correo }}</p>

        <p>FECHA: {{ \Carbon\Carbon::parse($presupuesto->fecha)->format('d/m/Y') }}</p>
                <p class="text-right"> VALIDEZ: {{ $presupuesto->validez }}</p>

    </div>

    <table class="table mb-4">
        <thead>
            <tr>
                <th>ITEM</th>
                <th>COD</th>
                <th>DESCRIPCIÓN</th>
                <th>CANT</th>
                <th>PRECIO UNITARIO</th>
                <th>PRECIO TOTAL</th>
            </tr>
        </thead>
        <tbody>
            @foreach($presupuesto->items as $item)
            <tr>
                <td>{{ $item->id }}</td>
                <td>{{ $item->codigo }}</td>
                <td>{{ $item->descripcion }}</td>
                <td>{{ $item->cantidad }}</td>


    @if($presupuesto->empresa_id == 1) {{-- ¡Ahora es un objeto! --}}
                <td class="text-right">${{ number_format($item->precio_unitario, 2) }}</td>
                <td class="text-right">${{ number_format($item->precio_total, 2) }}</td>
    @else
                <td class="text-right">${{ number_format($item->precio_unitario / 0.7 , 2) }}</td>
                <td class="text-right">${{ number_format($item->precio_total / 0.7 , 2) }}</td>

    @endif
            </tr>
            @endforeach
        </tbody>
    </table>
        </br>
        </br>
        </br>
        </br>
        </br>
        </br>
        </br>
        </br>
        </br>

    <div class="totals">


          @if($presupuesto->empresa_id == 1) {{-- ¡Ahora es un objeto! --}}
        <p class="text-right">SUB-TOTAL USD: ${{ number_format($presupuesto->subtotal - $presupuesto->subtotal  * $presupuesto->iva / 100, 2) }}</p>
        <p class="text-right">IVA: 16% ${{ number_format($presupuesto->subtotal * $presupuesto->iva / 100, 2) }}</p>
        <p class="text-right">Descuento: ${{ number_format($presupuesto->descuento ?? 0, 2) }}</p>
        <p class="text-right">TOTAL USD: ${{ number_format($presupuesto->total, 2) }}</p>
          @else
        <p class="text-right">SUB-TOTAL USD: ${{ number_format($presupuesto->subtotal - $presupuesto->subtotal  * $presupuesto->iva / 100, 2 ) }}</p>
        <p class="text-right">IVA: 16% ${{ number_format($presupuesto->subtotal * $presupuesto->iva / 100, 2) }}</p>
        <p class="text-right">Descuento: ${{ number_format($presupuesto->descuento ?? 0, 2) }}</p>
        <p class="text-right">TOTAL USD: ${{ number_format($presupuesto->total, 2) }}</p>
         @endif

    </div>
</body>
</html>
