<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{
    // protected $connection = 'inventario';
    protected $table = 'inventario';

    public $timestamps = true;

    protected $fillable = [
        'id',
        'codigo',
        'descripcion',
        'cantidad_stock',
        'precio_unitario',
        'proveedor_id'
    ];
}
