<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
    public function ordenesTrabajo(): BelongsToMany
{
    return $this->belongsToMany(OrdenTrabajo::class, 'ot_ayudantes', 'ayudante_id', 'orden_trabajo_id');
}
}