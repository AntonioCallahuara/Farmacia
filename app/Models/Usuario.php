<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable
{
    use Notifiable;

    /**
     * Nombre de la tabla en la base de datos
     */
    protected $table = 'usuario';

    /**
     * Atributos que se pueden asignar masivamente
     */
    protected $fillable = [
        'persona_id',
        'nombre_usuario',
        'contrasena',
        'rol',
        'estado',
        'ultimo_acceso',
        'intentos_fallidos',
    ];

    /**
     * Atributos que deben ocultarse en las respuestas JSON
     */
    protected $hidden = [
        'contrasena',
    ];

    /**
     * Atributos que deben convertirse a tipos nativos
     */
    protected $casts = [
        'ultimo_acceso' => 'datetime',
        'intentos_fallidos' => 'integer',
    ];

    /**
     * Laravel necesita saber que la columna de contraseña es 'contrasena'
     * en lugar de 'password'
     */
    public function getAuthPassword()
    {
        return $this->contrasena;
    }

    /**
     * Relación: Un usuario pertenece a UNA persona
     */
    public function persona()
    {
        return $this->belongsTo(Persona::class, 'persona_id');
    }

    /**
     * Relación: Un usuario registra MUCHAS ventas
     */
    public function ventas()
    {
        return $this->hasMany(Venta::class, 'usuario_id');
    }

    /**
     * Relación: Un usuario registra MUCHAS compras
     */
    public function compras()
    {
        return $this->hasMany(Compra::class, 'usuario_id');
    }

    /**
     * Verificar si el usuario es administrador
     */
    public function esAdministrador(): bool
    {
        return $this->rol === 'ADMINISTRADOR';
    }

    /**
     * Verificar si el usuario es farmacéutico
     */
    public function esFarmaceutico(): bool
    {
        return $this->rol === 'FARMACEUTICO';
    }

    /**
     * Verificar si el usuario es auxiliar
     */
    public function esAuxiliar(): bool
    {
        return $this->rol === 'AUXILIAR';
    }
}