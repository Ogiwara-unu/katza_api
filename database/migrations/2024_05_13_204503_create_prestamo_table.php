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
        Schema::create('prestamos', function (Blueprint $table) {
            $table->id('idPrestamo');
            $table->unsignedBigInteger('empleadoEmisor');
            $table->foreign('empleadoEmisor')->references('idEmpleado')->on('empleados');
            $table->unsignedBigInteger('empleadoReceptor');
            $table->foreign('empleadoReceptor')->references('idEmpleado')->on('empleados');
            $table->enum('estadoPrestamo', ['activo', 'completado']);
            $table->date('fechaPrestamo');
            $table->date('fechaLimite');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prestamos');
    }
};
