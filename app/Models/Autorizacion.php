<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Autorizacion extends Model
{
    use HasFactory;

    protected $table = 'autorizaciones';

    protected $fillable = [
        'NomAgencia', 'Cedula', 'Cuenta', 'Detalle', 'Estado', 'Solicitud', 'Validacion', 'Aprobacion'
    ];
}
