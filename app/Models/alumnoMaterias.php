<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class alumnoMaterias extends Model
{
    use HasFactory;
    protected $table = 'alumnoMaterias';
    protected $fillable = [
        'alumno_id',
        'materia_id'
    ];


}
