<?php
namespace App\Http\Controllers;

use App\Models\Presupuesto;
use App\Models\Clientes;
use App\Models\EstatusPresupuesto;
use App\Models\Inventario;
use App\Models\Empresa;
use App\Models\Contacto; // Asegúrate de que este es el nombre correcto
use Dompdf\Dompdf; // Importación de Dompdf
use Dompdf\Options; // Importación de Options
use PDF; // Si estás usando alguna otra biblioteca de PDF

class PresupuestoController extends Controller
{
    public function index()
    {
        $presupuestos = Presupuesto::with('cliente')->paginate(10);
        return view('presupuestos.index', compact('presupuestos'));
    }

    public function generatePDF($id)
    {
        // Cargar el presupuesto junto con las relaciones necesarias
        $presupuesto = Presupuesto::with(['cliente', 'items', 'contactos','estatus_presupuesto'])->findOrFail($id);
      
      
      
        // Obtener la empresa asociada al presupuesto
        $empresa = Empresa::findOrFail($presupuesto->empresa_id);
              
        // Obtener el contacto asociado al cliente
       $contacto = Contacto::findOrFail($presupuesto->cliente_id);

        // Obtener información de la empresa
        $direccion = $empresa->direccion;
        $descripcion = $empresa->descripcion;

        // Obtener el nombre del contacto
        $nombre = $contacto->nombre;
      
        // Renderizar la vista del PDF
       $html = view('presupuestos.pdf', compact('presupuesto', 'descripcion', 'direccion','nombre'))->render();

         //    $html = view('presupuestos.pdf', compact('presupuesto', 'descripcion', 'direccion'))->render();

     
        // Configuración de DomPDF
        $options = new Options();
        $options->set('defaultFont', 'Aptos Narrow');
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // Agregar numeración de página
        $canvas = $dompdf->getCanvas();
        $pageCount = $canvas->get_page_count();
        for ($i = 1; $i <= $pageCount; $i++) {
            $canvas->page_script(function ($pageNumber, $pageCount, $canvas, $fontMetrics) {
                $text = "Página $pageNumber de $pageCount";
                $font = $fontMetrics->get_font("Arial, sans-serif");
                $size = 10;
                $width = $fontMetrics->getTextWidth($text, $font, $size);
                $canvas->text(520 - $width, 800, $text, $font, $size);
            });
        }

        // Devolver el PDF generado al navegador
        //return $dompdf->stream("PRESUPUESTO_{$presupuesto->id}.pdf", ["Attachment" => false]); // en navegador 
        return $dompdf->stream("PRESUPUESTO_{$presupuesto->id}.pdf", ["Attachment" => true]); // descargar

    }
}
