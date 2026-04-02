<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OrdenTrabajo extends Model
{
    protected $table = 'ordenes_trabajo';

    protected $fillable = [
        'cliente_id',
        'direccion_id',
        'tipo_servicio',
        'cantidad_equipos',
        'estado',
        'descripcion',
        'fecha_inicio',
        'fecha_termino',
        'observaciones',
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_termino' => 'date',
    ];

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class);
    }

    public function direccion(): BelongsTo
    {
        return $this->belongsTo(Direccion::class);
    }

    public function tecnicos(): BelongsToMany
    {
        return $this->belongsToMany(Tecnico::class, 'ot_tecnicos', 'orden_trabajo_id', 'tecnico_id');
    }

    public function materiales(): HasMany
    {
        return $this->hasMany(OtMaterial::class, 'orden_trabajo_id');
    }

    public function ayudantes(): BelongsToMany
    {
        return $this->belongsToMany(Ayudante::class, 'ot_ayudantes', 'orden_trabajo_id', 'ayudante_id');
    }

    public function equipos(): BelongsToMany
    {
        return $this->belongsToMany(Equipo::class, 'ot_equipo')
            ->withPivot(['trabajo_realizado', 'estado_final', 'presion_alta', 'presion_baja', 'temperatura_salida', 'amperaje'])
            ->withTimestamps();
    }
}
