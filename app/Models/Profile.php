<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $table = 'profile';
    protected $fillable = ['id','name','estatus']; // Asegúrate de incluir 'user'

    public function user()
    {
     //   return $this->belongsTo(User::class, 'user'); // Especifica que 'user' es la clave foráneayyy
            return $this->belongsTo(User::class);

    }
    public function estatus()
    {
    //    return $this->belongsTo(Estatus::class, 'estatus'); // Asegúrate de usar el nombre correcto de la columna
          return $this->belongsTo(Estatus::class, 'estatus_id'); // Asegúrate de usar el nombre correcto de la columna

    }

}
