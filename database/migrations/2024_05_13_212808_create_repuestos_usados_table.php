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
        Schema::create('repuestosUsados', function (Blueprint $table) {
            $table->id('idRepuestosUsados');
            $table->unsignedBigInteger('repuesto');
            $table->foreign('repuesto')->references('idRepuesto')->on('repuestos');
            $table->integer('cantidadUsada');
            $table->unsignedBigInteger('mantenimiento');
            $table->foreign('mantenimiento')->references('idMantenimiento')->on('mantenimientos');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('repuestosUsados');
    }
};
