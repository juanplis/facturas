<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Items extends Model
{
    // protected $connection = 'items';
    protected $table = 'items';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'presupuesto_id',
        'codigo',
        'descripcion',
        'cantidad',
        'precio_unitario',
        'precio_total'

    ];
}
