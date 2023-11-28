<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\materia;
use Illuminate\Database\Eloquent\Model;

class ciclo extends Model
{
    use HasFactory;
    protected $fillable=[
        'nombreCiclo'
    ];

    public function materia(){
        return $this->hasMany(materia::class, 'ciclo_id');
    }
}
