<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contratacion extends Model
{
    use HasFactory;

    protected $table = 'contrataciones';

    protected $fillable = [
        'nombre_conductor',
        'nombre_servicio',
        'tipo_servicio',
        'fecha_contratacion',
        'direccion',
        'solicitud_contratacion_id'
    ];

    // Definir relaciones con otras tablas
    public function solicitudContratacion()
    {
        return $this->belongsTo(SolicitudContratacion::class, 'solicitud_contratacion_id');
    }
}
