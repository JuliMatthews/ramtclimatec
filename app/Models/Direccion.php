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
        'telefono',
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

    public function equipos(): HasMany
    {
        return $this->hasMany(Equipo::class);
    }

    public function getDireccionCompletaAttribute(): string
    {
        $dir = $this->calle . ' ' . $this->numero;
        if ($this->depto) {
            $dir .= ', Depto ' . $this->depto;
        }
        if ($this->comuna) {
            $dir .= ', ' . $this->comuna;
        }
        return $dir;
    }
}
