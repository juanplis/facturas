<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;


class Presupuesto extends Model
{
    public $timestamps = false; // Desactiva el uso de timestamps

    protected $table = 'presupuestos';

    protected $fillable = [
        'cliente_id',
        'fecha',
        'subtotal',
        'total',
        'condiciones_pago',
        'validez'
    ];
}
