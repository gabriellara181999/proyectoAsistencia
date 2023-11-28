<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\diaHorario;
class horario extends Model
{
    use HasFactory;
    protected $fillable = [
        'dia',
        'turno',
        'horaApertura',
        'horaFinalizacion'
    ];

    public function diaHorario(){
        return $this->hasMany(diaHorario::class, 'diaHorario_id');
    }
}
