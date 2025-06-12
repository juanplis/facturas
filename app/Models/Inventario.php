<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventario extends Model
{
    use HasFactory;

    // Especifica el nombre de la tabla si no sigue la convención de pluralización
    protected $table = 'inventario';

    // Si tu tabla tiene un campo 'id' que no es auto-incremental o no usa timestamps,
    // puedes desactivar estas características:
    // protected $primaryKey = 'id';
    // public $incrementing = false;
    // public $timestamps = false;

    // Si necesitas definir los campos que son asignables en masa
    protected $fillable = [
        'codigo',
        'descripcion',
        'precio_steel',
        'precio_tu_cocina',
        'costos',
        'concepto_general',
        'version',
        'dimensiones',
        'detalles'
    ];
}
