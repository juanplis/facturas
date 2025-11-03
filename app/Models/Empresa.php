<?php

// app/Models/Empresa.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    protected $table = 'empresa'; // because the table is not the conventional plural

    protected $fillable = [
        'razon_social', 'rif', 'telefono', 'correo_empresa','estatus', 'fecha_registro','direccion','telefono','telefono1'];

    // If you want to use timestamps, but the table has 'fecha_registro' instead of 'created_at'
    // We'll disable the default timestamps
    public $timestamps = false;

    // If you want to cast the fecha_registro as a date
    protected $dates = ['fecha_registro'];
}
