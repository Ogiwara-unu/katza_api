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
        Schema::create('dispositivos', function (Blueprint $table) {
            $table->id('idDispositivos');
            $table->unsignedBigInteger('tipoDispositivo');
            $table->foreign('tipoDispositivo')->references('idTipoDispositivo')->on('tipoDispositivos');
            $table->string('modeloDispositivo');
            $table->integer('cantidad');
            $table->string('marca');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dispositivos');
    }
};
