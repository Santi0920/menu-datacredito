<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class Persona extends Model
{
    use HasFactory;

    protected $table = 'persona';


    // protected $fillable = [
    //     'Cedula',
    //     'Nombre',
    //     'Apellidos',
    //     'Score',
    //     'Reporte',
    //     'CuentaAsociada',
    //     'Agencia',
    //     'Estado',
    //     'Activado',
    //     'DeudaEsp',
    //     'Enviado',
    //     'Consulta',
    //     'Tipo',
    //     'TipoAsociado',
    //     'FechaCorreo',
    // ];
}
