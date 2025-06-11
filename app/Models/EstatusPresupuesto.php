<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EstatusPresupuesto extends Model
{
    protected $table = 'estatus_presupuesto';
    protected $primaryKey = 'id'; // Debe coincidir con la FK

    protected $fillable = [
        'id',
        'nombre',
        'estatus'
    ];

    // Relación inversa con Presupuesto
    public function presupuestos()
    {
        return $this->hasMany(Presupuesto::class, 'estatus_presupuesto');
    }
}
