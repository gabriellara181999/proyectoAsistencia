<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class materia extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombreMateria',
        'numero',
        'requisito',
        'unidadValorativa',
        'ciclo_id',
        'user_id',
        'carrera_id',
        'diaHorario_id',
        'diaHorario_idv2'
    ];

    public function ciclo(){
        return $this->belongsTo(ciclo::class, 'id');
    }
    public function diaHorario(){
        return $this->belongsTo(diaHorario::class, 'id');
    }
    public function diaHorario2(){
        return $this->belongsTo(diaHorario::class, 'id');
    }
}
