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
        Schema::create('persona', function (Blueprint $table) {
            $table->id();
            $table->string('ci', 12)->unique();
            $table->string('nombre', 20);
            $table->string('apellido', 30);
            $table->date('fecha_nacimiento')->nullable();
            $table->string('telefono', 10)->nullable();
            $table->string('email', 35)->nullable();
            $table->string('direccion', 60)->nullable();
            $table->enum('tipo_persona', ['ADMINISTRATIVO', 'FARMACEUTICO', 'AUXILIAR'])->default('AUXILIAR');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('persona');
    }
};
