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
        Schema::create('detallePrestamoDispositivo', function (Blueprint $table) {
            $table->id('idDetallePrestamoDispositivo');
            $table->string('observaciones')->nullable();
            $table->unsignedBigInteger('prestamo');
            $table->foreign('prestamo')->references('idPrestamo')->on('prestamos');
            $table->unsignedBigInteger('dispositivosPrestado');
            $table->foreign('dispositivosPrestado')->references('idDispositivos')->on('dispositivos');
            $table->date('fechaDevolucion');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detallePrestamoDispositivo');

    }

    
};
