<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cliente extends Model
{
    protected $table = 'clientes';

    protected $fillable = [
    'rut',
    'nombre',
    'tipo',
    'region',
    'provincia',
    'comuna',
    'email',
    'telefono',
    'observaciones',
    'activo',
];

    protected $casts = [
        'activo' => 'boolean',
    ];

    public function direcciones(): HasMany
    {
        return $this->hasMany(Direccion::class);
    }

    public function ordenesTrabajo(): HasMany
    {
        return $this->hasMany(OrdenTrabajo::class);
    }
}