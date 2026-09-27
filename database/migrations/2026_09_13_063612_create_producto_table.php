<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('producto', function (Blueprint $table) {
            $table->id();
            $table->foreignId('categoria_id')->constrained('categoria')->onDelete('restrict')->onUpdate('cascade');
            $table->string('nombre_comercial', 40);
            $table->string('nombre_generico', 40)->nullable();
            $table->string('descripcion', 160)->nullable();
            $table->string('presentacion', 20)->nullable();
            $table->decimal('precio_compra', 10, 2)->default(0);
            $table->decimal('precio_venta', 10, 2);
            $table->integer('stock')->default(0);
            $table->integer('stock_minimo')->default(5);
            $table->boolean('requiere_receta')->default(false);
            $table->enum('estado', ['ACTIVO', 'INACTIVO', 'DESCONTINUADO'])->default('ACTIVO');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('producto');
    }
};
