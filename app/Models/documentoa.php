<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class documentoa extends Model
{
    use HasFactory;

    protected $table = 'documentoa';

    protected $fillable = [
        'ID_Persona',
    ];
}
