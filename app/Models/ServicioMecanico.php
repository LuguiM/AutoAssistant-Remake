<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicioMecanico extends Model
{
    use HasFactory;

    protected $table = 'servicios_mecanicos';

    protected $fillable = [
        'logo',
        'rubro',
        'servicio',
        'tipo_servicio',
        'descripcion',
        'dia_inicio',
        'dia_fin',
        'hora_apertura',
        'hora_cierre',
        'precio',
        'precio_adomicilio',
        'perfil_mecanico_id'
    ];

    // Definir relaciones con otras tablas
    public function perfilMecanico()
    {
        return $this->belongsTo(PerfilMecanico::class, 'perfil_mecanico_id');
    }
}
