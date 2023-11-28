<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\carrera;

class Facultade extends Model
{
    use HasFactory;
    protected $fillable = [
        'nombreFacultad'
    ];

    public function carrera(){
        return $this->hasMany(carrera::class, 'facultad_id');
    }
}
