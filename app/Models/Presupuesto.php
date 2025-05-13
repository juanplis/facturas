<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;




class Presupuesto extends Model
{
    // Relación con Cliente (1 presupuesto pertenece a 1 cliente)
    public function clientes(): BelongsTo
    {
        return $this->belongsTo(Clientes::class, 'cliente_id');
    }

    // Relación con Items (1 presupuesto tiene muchos items)
    public function items()
    {
        return $this->hasMany(Item::class);
    }

}
