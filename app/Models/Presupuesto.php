<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Presupuesto extends Model
{
    protected $table = 'presupuestos';

    public $timestamps = false; // Desactiva las marcas de tiempo

    protected $fillable = [
        'Cliente_ID',
        'Fecha',
        'Subtotal',
        'Total',
        'Condiciones_Pago',
        'Validez'
    ];
}
