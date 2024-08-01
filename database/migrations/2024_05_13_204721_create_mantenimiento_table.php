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
        Schema::create('mantenimientos', function (Blueprint $table) {
            $table->id('idMantenimiento');
            $table->unsignedBigInteger('idVehiculo');
            $table->foreign('idVehiculo')->references('placaVehiculo')->on('vehiculos');
            $table->unsignedBigInteger('tipoMantenimiento');
            $table->foreign('tipoMantenimiento')->references('idTipoMantenimiento')->on('tipoMantenimientos');
            $table->unsignedBigInteger('empleadoEncargado');
            $table->foreign('empleadoEncargado')->references('idEmpleado')->on('empleados');
            $table->date('fechaMantenimiento');
            $table->text('duracionMantenimiento', 100);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mantenimiento');
    }
};
