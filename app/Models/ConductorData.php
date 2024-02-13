<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConductorData extends Model
{
    use HasFactory;

    protected $table = 'conductor_data';

    protected $fillable = [
        'licencia',
        'numero_licencia',
        'user_id'
    ];

    // Definir relaciones con otras tablas
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
