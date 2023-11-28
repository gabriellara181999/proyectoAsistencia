<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class asistencia extends Model
{
    use HasFactory;
    protected $fillable =[
        'fechaAsistencia',
        'inscritoMateria',
        'estudianteAsistencia',
        'materia_id',
        'user_id',
        'Qr_id',
        'estado_id',
    ];

    public function alumnoasistencia(){
        return $this->hasMany(alumnoasistencia::class, 'asistencia_id');
    }
}
