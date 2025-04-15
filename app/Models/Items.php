<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Items extends Model
{
    // protected $connection = 'items';
    protected $table = 'items';

    public $timestamps = false;

    protected $fillable = [
        'ID',
        'Presupuesto_ID',
        'Codigo',
        'Descripcion',
        'Cantidad',
        'Precio_Unitario',
        'Precio_Total'

    ];
}
