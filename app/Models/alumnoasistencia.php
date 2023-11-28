<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class alumnoasistencia extends Model
{
    use HasFactory;
    protected $table = 'alumnoasistencias';
    protected $fillable = [
        'fechaAsistencia',
        'alumno_id',
        'estadoAlumno_id',
        'asistencia_id'
    ];

    public function asistencia(){
        return $this->belongsTo(asistencia::class, 'id');
    }
}
