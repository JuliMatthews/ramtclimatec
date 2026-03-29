<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ayudante extends Model
{
    protected $table = 'ayudantes';

    protected $fillable = [
    'nombre',
    'rut',
    'telefono',
    'email',
    'region',
    'provincia',
    'comuna',
    'observaciones',
    'activo',
];

    protected $casts = [
        'activo' => 'boolean',
    ];
}