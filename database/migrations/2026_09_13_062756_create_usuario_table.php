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
        Schema::create('usuario', function (Blueprint $table) {
            $table->id();
            $table->foreignId('persona_id')->constrained('persona')->onDelete('cascade')->onUpdate('cascade');
            $table->string('nombre_usuario', 20)->unique();
            $table->string('contrasena');
            $table->enum('rol', ['ADMINISTRADOR', 'FARMACEUTICO', 'AUXILIAR'])->default('AUXILIAR');
            $table->enum('estado', ['ACTIVO', 'INACTIVO', 'BLOQUEADO'])->default('ACTIVO');
            $table->timestamp('ultimo_acceso')->nullable();
            $table->integer('intentos_fallidos')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuario');
    }
};
