<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class materiaInscrita extends Model
{
    use HasFactory;
    protected $fillable=[
        'cantidadMateria'
    ];
}
