<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TasaBcv extends Model
{
 public $timestamps = true; // Habilita el uso de timestamps

    protected $table = 'tasa_bcvs'; // Apunta a la tabla 'users'

    protected $fillable = [
        'id',
        'fecha_bcv',
        'monto_bcv',
        'monto_bcv_euro',
        'intervenciones',
        'estatus',
        'created_at',
        'updated_at'
    ];
}
