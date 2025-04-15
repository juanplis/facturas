<?php

namespace App\Http\Controllers;

use PDF; // Asegúrate de importar la fachada
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class PresupuestoController extends Controller
{
    public function generatePDF()
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
    }
}
