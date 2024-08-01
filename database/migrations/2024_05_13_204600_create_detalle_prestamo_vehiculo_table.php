<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.s
     */
    public function up(): void
    {
        Schema::create('detallePrestamoVehiculos', function (Blueprint $table) {
            $table->id('idDetallePrestamo');
            $table->unsignedBigInteger('prestamo');
            $table->foreign('prestamo')->references('idPrestamo')->on('prestamos');
            $table->text('observaciones')->nullable();
            $table->string('kmInicial', 50);
            $table->string('kmFinal', 50);
            $table->unsignedBigInteger('vehiculoPrestado');
            $table->foreign('vehiculoPrestado')->references('placaVehiculo')->on('vehiculos');
            $table->date('fechaDevolucion');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detallePrestamoVehiculos');
    }
};
