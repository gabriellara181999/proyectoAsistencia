<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class alumno extends Authenticatable
{
    use HasRoles, HasApiTokens, HasFactory, Notifiable;
    protected $fillable=[
        'name',
        'apellido',
        'fechaNacimiento',
        'sexo',
        'numeroEstudiante',
        'email',
        'password',
        'telefono',
        'ciclo_id',
        'carrera_id',
        'materiaInscrita_id'
    ];
}
