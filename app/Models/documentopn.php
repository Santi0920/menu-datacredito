<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class documentopn extends Model
{
    use HasFactory;

    protected $table = 'documentopn';

    protected $fillable = [
        'ID_Persona',
    ];
}
