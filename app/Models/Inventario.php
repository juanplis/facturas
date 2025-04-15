<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{
    // protected $connection = 'inventario';
    protected $table = 'inventario';

    public $timestamps = true;

    protected $fillable = [
        'ID',
        'Codigo',
        'Descripcion',
        'Cantidad_Stock',
        'Precio_Unitario',
        'Proveedor_ID'
    ];
}
