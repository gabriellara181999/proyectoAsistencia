<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class carrera extends Model
{
    use HasFactory;
    protected $fillable=[
        'nombreCarrera',
        'facultad_id',
    ];

    public function Facultade(){
        return $this->belongsTo(Facultade::class, 'id');
    }
}
