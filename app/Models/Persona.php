<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    protected $fillable = [
        'Cedula',
        'Nombre',
        'Apellidos',
        'rol'
    ];
    
    
    use HasFactory;

    
}
