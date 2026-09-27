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
        Schema::create('lote', function (Blueprint $table) {
            $table->id();
            $table->foreignId('producto_id')->constrained('producto')->onDelete('cascade')->onUpdate('cascade');
            $table->string('numero_lote', 20);
            $table->date('fecha_fabricacion')->nullable();
            $table->date('fecha_vencimiento');
            $table->integer('cantidad')->default(0);
            $table->decimal('precio_compra', 5, 2)->default(0);
            $table->enum('estado', ['DISPONIBLE', 'PROXIMO_VENCER', 'VENCIDO', 'AGOTADO'])->default('DISPONIBLE');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lote');
    }
};
