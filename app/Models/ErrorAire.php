<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ErrorAire extends Model
{
    protected $fillable = ['codigo', 'marca', 'error', 'causa', 'solucion'];
}