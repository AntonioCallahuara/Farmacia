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
        Schema::create('cliente', function (Blueprint $table) {
            $table->id();
            $table->string('ci', 12)->unique();
            $table->string('nombre', 20);
            $table->string('apellido', 30)->nullable();
            $table->string('telefono', 10)->nullable();
            $table->string('email', 35)->nullable();
            $table->string('direccion', 60)->nullable();
            $table->date('fecha_registro');
            $table->enum('estado', ['ACTIVO', 'INACTIVO'])->default('ACTIVO');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cliente');
    }
};
