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
        Schema::create('empleados', function (Blueprint $table) {
            $table->id('idEmpleado');
            $table->string('cedula', 50);  //AGREGUE EL CAMPO CEDULA
            $table->string('nombre', 50);
            $table->string('apellidos', 70);
            $table->string('correo', 45);
            $table->string('telefono', 45);
            $table->unsignedBigInteger('departamento');
            $table->foreign('departamento')->references('idDepartamento')->on('departamentos');
            $table->date('fechaContratacion');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empleados');
    }
};
