<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Equipo extends Model
{
    protected $table = 'equipos';

    protected $fillable = [
        'cliente_id',
        'direccion_id',
        'ubicacion',
        'marca',
        'modelo',
        'numero_serie',
        'tension_nominal',
        'frecuencia',
        'potencia_calefaccion',
        'potencia_enfriamiento',
        'capacidad_calefaccion_btu',
        'capacidad_enfriamiento_btu',
        'masa_refrigerante',
        'tipo_refrigerante',
        'presion_minima',
        'presion_maxima',
        'pais_fabricacion',
        'fecha_fabricacion',
        'ultima_mantencion',
        'proxima_mantencion',
        'observaciones',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
        'ultima_mantencion' => 'date',
        'proxima_mantencion' => 'date',
    ];
    protected static function booted()
    {
        static::saving(function ($equipo) {
            // Si la última mantención cambió o es nueva, calculamos la próxima (+6 meses)
            if ($equipo->isDirty('ultima_mantencion') && $equipo->ultima_mantencion) {
                $equipo->proxima_mantencion = \Illuminate\Support\Carbon::parse($equipo->ultima_mantencion)->addMonthsNoOverflow(6);
            }
        });
    }
    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class);
    }

    public function direccion(): BelongsTo
    {
        return $this->belongsTo(Direccion::class);
    }

    public function ordenesTrabajo(): BelongsToMany
    {
        return $this->belongsToMany(OrdenTrabajo::class, 'ot_equipo')
            ->withPivot(['trabajo_realizado', 'estado_final', 'presion_alta', 'presion_baja', 'temperatura_salida', 'amperaje'])
            ->withTimestamps();
    }
}
