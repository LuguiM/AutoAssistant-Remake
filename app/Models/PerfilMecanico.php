<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PerfilMecanico extends Model
{
    use HasFactory;

    protected $table = 'perfil_mecanico';

    protected $fillable = [
        'logo',
        'nombre_taller',
        'representante',
        'direccion',
        'numero',
        'user_id'
    ];

    // Definir relaciones con otras tablas
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
