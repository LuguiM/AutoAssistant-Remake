<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rechazo extends Model
{
    use HasFactory;

    protected $table = 'rechazo';

    protected $fillable = [
        'motivo',
        'solicitud_contratacion_id'
    ];

    // Definir relaciones con otras tablas
    public function solicitudContratacion()
    {
        return $this->belongsTo(SolicitudContratacion::class, 'solicitud_contratacion_id');
    }
}
