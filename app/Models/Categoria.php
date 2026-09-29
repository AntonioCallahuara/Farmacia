<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $table = 'categoria';

    protected $fillable = [
        'nombre',
        'descripcion',
        'estado',
    ];

    // Relación: Una categoría tiene MUCHOS productos
    public function productos()
    {
        return $this->hasMany(Producto::class, 'categoria_id');
    }
}