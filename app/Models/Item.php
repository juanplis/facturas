<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Item extends Model  // ✅ Modelo corregido
{
    protected $table = 'items';  // ← Opcional pero recomendado

    public function presupuesto(): BelongsTo
    {
        return $this->belongsTo(Presupuesto::class, 'presupuesto_id');
    }

    public $timestamps = false;

    protected $fillable = [
        'id',
        'presupuesto_id',
        'codigo',
        'descripcion',
        'cantidad',
        'precio_unitario',
        'precio_total'

    ];
  
  
  public function items()
    {
        return $this->hasMany(Items::class, 'presupuesto_id');
    }
}

