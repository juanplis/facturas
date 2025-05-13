<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Clientes extends Model
{
    // protected $connection = 'clientes';
    protected $table = 'clientes';

    public $timestamps = true;

    protected $fillable = [
        'id',
        'nombre',
        'rif',
        'direccion',
        'telefono',
        'correo'
    ];
    public function presupuestos() {
        return $this->hasMany(Presupuesto::class);
    }
}
