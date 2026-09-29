<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    protected $table = 'proveedor';

    protected $fillable = [
        'codigo',
        'nombre',
        'razon_social',
        'nit',
        'telefono',
        'celular',
        'email',
        'direccion',
        'contacto',
        'estado',
    ];

    // Relación: Un proveedor suministra MUCHAS compras
    public function compras()
    {
        return $this->hasMany(Compra::class, 'proveedor_id');
    }
}