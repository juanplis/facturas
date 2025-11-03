<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{
    use HasFactory;

    // Nombre de la tabla si no sigue la convención de plural
    protected $table = 'inventario';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
      	'id',
        'codigo',
        'descripcion',
        'precio_unitario',
        // 'precio_tu_cocina', // Descomenta si los añades a la validación
        // 'costo',             // Descomenta si los añades a la validación
        'concepto_general',
        'version',
        'dimensiones',
        'detalles',
    ];

    // ... otros métodos del modelo
}



