<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estados extends Model
{
    use HasFactory;
//     protected $table = 'mi_tabla_personalizada';
// protected $primaryKey = 'mi_clave_primaria_personalizada';


    protected $fillable = [
        'estado',
        'color',
        'icon',
    ];
}
