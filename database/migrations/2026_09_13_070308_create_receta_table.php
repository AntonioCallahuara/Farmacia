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
        Schema::create('receta', function (Blueprint $table) {
            $table->id();
            $table->date('fecha_emision');
            $table->date('fecha_vencimiento');
            $table->string('medico_prescriptor', 40);
            $table->string('matricula_profesional', 20);
            $table->enum('estado', ['VIGENTE','VENCIDA','UTILIZADA'])->default('VIGENTE');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('receta');
    }
};
