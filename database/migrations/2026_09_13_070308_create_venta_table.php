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
            $table->foreignId('cliente_id')->nullable()->constrained('cliente')->onDelete('set null');
            $table->foreignId('usuario_id')->constrained('usuario')->onDelete('restrict');
            $table->string('numero_factura', 20)->unique();
            $table->date('fecha_venta');
            $table->time('hora_venta');
            $table->decimal('subtotal', 10, 2)->default(0);
            $table->decimal('descuento', 10, 2)->default(0);
            $table->decimal('impuesto', 10, 2)->default(0);
            $table->decimal('total', 10, 2)->default(0);
            $table->enum('metodo_pago', ['EFECTIVO','TARJETA_DEBITO','TARJETA_CREDITO','TRANSFERENCIA','QR'])->default('EFECTIVO');
            $table->enum('estado', ['COMPLETADA','ANULADA','PENDIENTE_PAGO'])->default('COMPLETADA');
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
