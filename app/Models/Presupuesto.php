<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Presupuesto extends Model
{
    protected $table = 'presupuestos';

    protected $fillable = [
        'cliente_id',
        'nombre',
        'archivo',
        'monto',
        'estado',
        'observaciones',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }
}
