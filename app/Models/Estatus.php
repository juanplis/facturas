<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estatus extends Model
{
/*    use HasFactory;

    protected $fillable = ['nombre']; // Asegúrate de incluir los campos que necesitas*/
  
      // protected $connection = 'clientes';
    protected $table = 'estatus';

    public $timestamps = true;

    protected $fillable = [
        'id',
        'nombre',
        'estatus'
    ];
  
}
