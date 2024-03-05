<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Observacion extends Model
{
    use HasFactory;

    protected $table = 'observaciones';

    protected $fillable = [
        'observacion',
        'solicitud_contratacion_id'
    ];

    // Definir relaciones con otras tablas
    public function solicitudContratacion()
    {
        return $this->belongsTo(Contratacion::class, 'solicitud_contratacion_id');
    }
}