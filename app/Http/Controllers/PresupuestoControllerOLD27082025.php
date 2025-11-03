<?php

namespace App\Http\Controllers;

use App\Models\Presupuesto;
use App\Models\Clientes;
use App\Models\EstatusPresupuesto;
use App\Models\Empresa; // Asegúrate de que la ruta sea correcta


use PDF; // ← Importación añadida

class PresupuestoController extends Controller
{
    public function index()
    {
        $presupuestos = Presupuesto::with('cliente')->paginate(10);
        return view('presupuestos.index', compact('presupuestos'));
    }

    public function generatePDF($id)
    {
        $presupuesto = Presupuesto::with(['cliente', 'items','contactos','estatus_presupuesto'])
            ->findOrFail($id);

        $empresa = Empresa::with([])
            ->findOrFail($presupuesto->empresa_id);


    // Acceder al campo 'direccion' directamente
    $direccion = $empresa->direccion;
    $descripcion = $empresa->descripcion;

/*
        $pdf = PDF::loadView('presupuestos.pdf', compact('presupuesto'))
            ->setPaper('a4', 'portrait')
            ->setOptions(['defaultFont' => 'sans-serif']); // ← Opción recomendada

        return $pdf->stream("SSC-{$presupuesto->id}.pdf");
*/
    return Pdf::loadView('presupuestos.pdf', [
        'presupuesto' => $presupuesto,
        'direccion' => $direccion,
        'descripcion' => $descripcion

        // Añade otras variables que necesites aquí
    ])->stream();

    }

    /*
    public function generatePDF2()
    {
        $data = [
            'cliente' => 'YORMY DAVILA',
            'rif' => 'V-11.954.532',
            'direccion' => 'Merida, Municipio Libertador, Pedregoza Sur, Residencias El Pinar, PB 5',
            'telefono' => '0424-7320480',
            'fecha' => '06/01/2025',
            'items' => [
                [
                    'cod' => '100010',
                    'descripcion' => 'Trampa Grasa estandar de A/I 304 con cestilla perforada recolectora de desechos, entrada y salida de 2" y desague de 3/4 para mantenimiento. Dimensiones: 45x35x35',
                    'cant' => 1,
                    'precio_unitario' => 306.00,
                    'precio_total' => 306.00
                ]
            ],
            'sub_total' => 306.00,
            'iva' => 48.96,
            'total' => 354.96,
            'condiciones_pago' => 'Primer pago del 80% para dar inicio a la fabricación o prestación de servicio contemplando entregas parciales. Segundo pago del 20% al momento de realizar la entrega o culminación de trabajo.',
            'tiempo_entrega' => 'Equipos nacionales 30 días e importados 90 días hábiles posterior al efectuarse el primer pago.'
        ];

        $pdf = PDF::loadView('presupuesto', $data);
        return $pdf->stream('PRESUPUESTO_661.pdf'); // Cambia a download si deseas descargar
    }*/
}
