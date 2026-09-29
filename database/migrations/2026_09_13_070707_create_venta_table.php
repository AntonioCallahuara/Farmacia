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
        Schema::create('venta', function (Blueprint $table) {
        $table->id();
        $table->foreignId('usuario_id')->constrained('usuario')->onDelete('restrict')->onUpdate('cascade');
        $table->foreignId('receta_id')->nullable()->constrained('receta')->onDelete('set null')->onUpdate('cascade');
        $table->string('numero_factura', 20)->unique();
        $table->date('fecha_venta');
        $table->time('hora_venta');
        $table->decimal('subtotal', 5, 2)->default(0);
        $table->decimal('descuento', 5, 2)->default(0);
        $table->decimal('impuesto', 5, 2)->default(0);
        $table->decimal('total', 5, 2)->default(0);
        $table->enum('metodo_pago', ['EFECTIVO', 'TARJETA_DEBITO', 'TARJETA_CREDITO', 'TRANSFERENCIA', 'QR'])->default('EFECTIVO');
        $table->enum('estado', ['COMPLETADA', 'ANULADA', 'PENDIENTE_PAGO'])->default('COMPLETADA');
        $table->timestamps();
        }); 
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('venta');
    }
};
