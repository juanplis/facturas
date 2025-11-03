<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Usuarios extends Model
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
        'profile_type'
    ];
  

}

