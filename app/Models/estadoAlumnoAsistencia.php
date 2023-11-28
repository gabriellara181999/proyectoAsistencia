<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class estadoAlumnoAsistencia extends Model
{
    use HasFactory;
    protected $table = 'estadoAlumnoAsistencias';
    protected $fillable = [
        'nombreEstadoAlumno'
    ];
}
