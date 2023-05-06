<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Datacredito extends Model
{
    protected $fillable = [
        'Cedula',
        'Nombre',
        'Apellidos',
        'Score',
        'Reporte',
        'CuentaAsociada',
        'Agencia',
        'FechaInsercion',
        'NombreSin',
        'NombrePN',
        'NombreT',
        'Consecutivof',
        'Tipof'
    ];

    use HasFactory;
}
