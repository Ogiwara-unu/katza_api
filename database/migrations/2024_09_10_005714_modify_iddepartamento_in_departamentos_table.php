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
        Schema::table('departamentos', function (Blueprint $table) {
            // Asegúrate de que la columna 'idDepartamento' está configurada para auto-incremento
            // Nota: Laravel normalmente maneja esto al crear la tabla, pero puedes verificar o ajustar según sea necesario
            $table->bigInteger('idDepartamento')->autoIncrement()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('departamentos', function (Blueprint $table) {
            // Revertir los cambios si es necesario
            $table->integer('idDepartamento')->change(); // Ajustar el tipo de columna según sea necesario
        });
    }
};
