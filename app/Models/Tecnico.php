<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tecnico extends Model
{
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
        return $this->belongsToMany(OrdenTrabajo::class, 'ot_tecnicos', 'tecnico_id', 'orden_trabajo_id');
    }
}
