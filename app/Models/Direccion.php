<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Direccion extends Model
{
    protected $table = 'direcciones';
    protected $fillable = [
    'cliente_id',
    'calle',
    'numero',
    'depto',
    'region',
    'provincia',
    'comuna',
    'ciudad',
    'referencia',
    'principal',
];

    protected $casts = [
        'principal' => 'boolean',
    ];

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class);
    }

    public function ordenesTrabajo(): HasMany
    {
        return $this->hasMany(OrdenTrabajo::class);
    }
}