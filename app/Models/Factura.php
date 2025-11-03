<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Factura extends Model
{
    // protected $connection = 'clientes';
    protected $table = 'facturas';

    public $timestamps = true;

    protected $fillable = [
       'id', 
      'tipo_empresa',
      'correlativo', 
      'fecha'
    ];
   
}
