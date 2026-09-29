<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    protected $table = 'persona';

    protected $fillable = [
        'ci',
        'nombre',
        'apellido',
        'fecha_nacimiento',
        'telefono',
        'email',
        'direccion',
        'tipo_persona',
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date',
    ];

    // Relación: Una persona tiene UN usuario
    public function usuario()
    {
        return $this->hasOne(Usuario::class, 'persona_id');
    }

    // Accesor: Nombre completo
    public function getNombreCompletoAttribute()
    {
        return "{$this->nombre} {$this->apellido}";
    }
}