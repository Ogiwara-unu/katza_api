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
        Schema::create('repuestos', function (Blueprint $table) {
            $table->id('idRepuesto');
            $table->unsignedBigInteger('cantidadInv');
            $table->unsignedBigInteger('tipoRepuesto');
            $table->foreign('tipoRepuesto')->references('idtipoRepuesto')->on('tipoRepuestos');
            $table->unsignedBigInteger('modeloRepuesto');
            $table->foreign('modeloRepuesto')->references('idModeloRepuesto')->on('modeloRepuestos');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('repuestos');
    }
};
