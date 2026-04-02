<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Material extends Model
{
    protected $table = 'materiales';

    protected $fillable = [
        'nombre',
        'unidad',
        'precio_unitario',
        'descripcion',
        'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
        'precio_unitario' => 'decimal:2',
    ];

    public function otMateriales(): HasMany
    {
        return $this->hasMany(OtMaterial::class);
    }
}
