<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'producto';

    protected $fillable = [
        'categoria_id',
        'codigo_barras',
        'nombre_comercial',
        'nombre_generico',
        'descripcion',
        'concentracion',
        'presentacion',
        'precio_compra',
        'precio_venta',
        'stock',
        'stock_minimo',
        'requiere_receta',
        'estado',
    ];

    protected $casts = [
        'precio_compra' => 'decimal:2',
        'precio_venta' => 'decimal:2',
        'stock' => 'integer',
        'stock_minimo' => 'integer',
        'requiere_receta' => 'boolean',
    ];

    // Relación: Un producto pertenece a UNA categoría
    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }

    // Relación: Un producto tiene MUCHAS imágenes
    public function imagenes()
    {
        return $this->hasMany(ProductoImagen::class, 'producto_id')->orderBy('orden');
    }

    // Relación: Un producto tiene UNA imagen principal
    public function imagenPrincipal()
    {
        return $this->hasOne(ProductoImagen::class, 'producto_id')->where('es_principal', true);
    }

    // Relación: Un producto tiene MUCHOS lotes
    public function lotes()
    {
        return $this->hasMany(Lote::class, 'producto_id');
    }

    // Relación: Un producto aparece en MUCHOS detalles de venta
    public function detallesVenta()
    {
        return $this->hasMany(DetalleVenta::class, 'producto_id');
    }

    // Relación: Un producto aparece en MUCHOS detalles de compra
    public function detallesCompra()
    {
        return $this->hasMany(DetalleCompra::class, 'producto_id');
    }

    // Relación: Un producto genera MUCHAS alertas
    public function alertas()
    {
        return $this->hasMany(Alerta::class, 'producto_id');
    }

    // Verificar si tiene stock suficiente
    public function tieneStock(int $cantidad = 1): bool
    {
        return $this->stock >= $cantidad;
    }

    // Verificar si tiene stock bajo
    public function tieneStockBajo(): bool
    {
        return $this->stock <= $this->stock_minimo;
    }
}