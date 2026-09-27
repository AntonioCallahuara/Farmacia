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
        Schema::create('alerta', function (Blueprint $table) {
            $table->id();
            $table->foreignId('producto_id')->constrained('producto')->onDelete('cascade');
            $table->foreignId('lote_id')->nullable()->constrained('lote')->onDelete('set null');
            $table->enum('tipo', ['STOCK_MINIMO','PROXIMO_VENCER','VENCIDO','SIN_STOCK']);
            $table->string('mensaje', 60);
            $table->date('fecha_generacion');
            $table->timestamp('fecha_lectura')->nullable();
            $table->enum('estado', ['PENDIENTE','LEIDA','ATENDIDA'])->default('PENDIENTE');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alerta');
    }
};
