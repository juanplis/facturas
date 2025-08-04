<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Empresa; // <-- ¡Asegúrate de que esta línea exista y sea correcta!




class Presupuesto extends Model
{
     // Especificar los atributos que se pueden asignar masivamente

    protected $table = 'presupuestos';
    protected $fillable = [
        'cliente_id',         // Agrega este atributo
        'subtotal',
        'total',
        'fecha',
        'validez',
        'condiciones_pago',
        'estatus_presupuesto',
        'empresa_id',
        'estatus_presupuesto',


        // Agrega otros atributos que necesites
    ];
    // Relación con Cliente (1 presupuesto pertenece a 1 cliente)
    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Clientes::class, 'cliente_id');
    }

    // Relación con Items (1 presupuesto tiene muchos items)
    public function items()
    {
        return $this->hasMany(Item::class, 'presupuesto_id');
    }
    // Relación con Contacto (1 presupuesto pertenece a 1 contacto)
    public function contactos(): BelongsTo
    {
        return $this->belongsTo(Contacto::class, 'cliente_id');
    }
    // En App\Models\Presupuesto.php
    public function estatus_presupuesto(): BelongsTo
    {
        return $this->belongsTo(EstatusPresupuesto::class, 'estatus_presupuesto');
    }
    public function estado() // ¡Nuevo nombre!
    {
        return $this->belongsTo(EstatusPresupuesto::class, 'estatus_presupuesto');
    }

    /**
     * Define la relación: Un presupuesto pertenece a una empresa.
     * El método se llama `empresa` (singular) para que sea accesible como `$presupuesto->empresa`.
     */
    public function empresa(): BelongsTo
    {
        // 'empresa_id' es la clave foránea en la tabla 'presupuestos'
        // que referencia a la clave primaria de la tabla 'empresas'
        return $this->belongsTo(Empresa::class, 'empresa_id');
    }

}
