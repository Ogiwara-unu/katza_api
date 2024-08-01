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
        Schema::create('modeloRepuestos', function (Blueprint $table) {
            $table->id('idModeloRepuesto');
            $table->string('modelo', 50);
            $table->unsignedBigInteger('marca');
            $table->foreign('marca')->references('idMarcaRepuesto')->on('marcaRepuestos');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modeloRepuestos');
    }
};
