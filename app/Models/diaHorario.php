<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\materia;
use Illuminate\Database\Eloquent\Model;

class diaHorario extends Model
{
    use HasFactory;
    protected $fillable=[
        'nombreDia', 
        'horario_id'
    ];

    public function horario(){
        return $this->belongsTo(horario::class, 'id');
    }

    public function materia(){
        return $this->hasMany(materia::class, 'diaHorario_id');
    }
    public function materias(){
        return $this->hasMany(materia::class, 'diaHorario_idv2');
    }

}
