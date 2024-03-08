<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    use HasFactory;
    protected $table = 'comentarios';


    protected $fillable = [
        'comentario',
        'calificacion',
        'contratacion_id',
        'user_id',
        'servicio_id'
    ];

    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    
    public function servicioMecanico()
    {
        return $this->belongsTo(ServicioMecanico::class);
    }
}
