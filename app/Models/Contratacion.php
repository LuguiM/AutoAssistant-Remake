<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contratacion extends Model
{
    use HasFactory;

    protected $table = 'contrataciones';

    protected $fillable = [
        'tipo_servicio',
        'fecha_contratacion',
        'comentario',
        'direccion',
        'servicio_id',
        'conductor_id',
        'mecanico_id',
        'estado_id'
    ];

    // Definir relaciones con otras tablas
   

    public function servicio()
    {
        return $this->belongsTo(ServicioMecanico::class, 'servicio_id');
    }

    public function conductor()
    {
        return $this->belongsTo(User::class, 'conductor_id');
    }

    public function mecanico()
    {
        return $this->belongsTo(ServicioMecanico::class, 'mecanico_id', 'perfil_mecanico_id');
    }

    public function estado()
    {
        return $this->belongsTo(Estados::class, 'estado_id');
    }
}
