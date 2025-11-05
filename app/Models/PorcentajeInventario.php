<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class PorcentajeInventario extends Model
{
    // protected $connection = 'clientes';
    protected $table = 'porcentaje_inventario';

    public $timestamps = true;

    protected $fillable = [
       'id',
      'porcentaje',
      'timestamp',
    ];

}
