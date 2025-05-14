<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;




class Presupuesto extends Model
{
     // Especificar los atributos que se pueden asignar masivamente
    protected $fillable = [
        'cliente_id',         // Agrega este atributo
        'subtotal',
        'total',
        'fecha',
        'validez',
        'condiciones_pago',
        // Agrega otros atributos que necesites
    ];
    // Relación con Cliente (1 presupuesto pertenece a 1 cliente)
    public function clientes(): BelongsTo
    {
        return $this->belongsTo(Clientes::class, 'cliente_id');
    }

    // Relación con Items (1 presupuesto tiene muchos items)
    public function items()
    {
        return $this->hasMany(Item::class, 'presupuesto_id');
    }

}
