<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class Iva extends Model
{
    use HasFactory;
    protected $table = 'iva';

    public $timestamps = false;
    protected $fillable = ['monto_iva', 'estatus', 'fecha']; // Campos que se pueden llenar masivamente
}

