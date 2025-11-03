<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{

public $timestamps = true; // Habilita el uso de timestamps

    protected $table = 'users'; // Apunta a la tabla 'users'

    protected $fillable = [
        'id',
        'name',
        'email',
        'email_verified_at',
        'password',
        'remember_token',
        'created_at',
        'updated_at',
         'perfil_id'
    ];

    public function perfil()
    {
        return $this->belongsTo(Profile::class, 'perfil_id'); // Asegúrate de que 'perfil_id' sea el nombre correcto de la clave foránea
    }

}