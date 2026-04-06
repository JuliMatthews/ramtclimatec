<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Error extends Model
{
    protected $fillable = [
        'marca',
        'tipo_equipo',
        'codigo_error',
        'descripcion',
        'causa_probable',
        'solucion',
        'notas',
    ];
}