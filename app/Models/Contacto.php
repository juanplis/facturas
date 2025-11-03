<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contacto extends Model
{
    use HasFactory;

    protected $fillable = [
        'cliente_id',
        'nombre',
        'telefono',
        'correo',
    ];
/*
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }*/
  
  	  public function cliente()
    {
        return $this->belongsTo(Clientes::class, 'cliente_id', 'id'); // Relación inversa
    }
  
  
}
