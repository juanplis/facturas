<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/XXXX_create_empresas_table.php
public function up() {
    Schema::create('empresas', function (Blueprint $table) {
        $table->id();
        $table->string('razon_social', 100);
        $table->string('rif', 20)->unique();  // ← Campo que genera el error
        $table->string('telefono', 15);
        $table->enum('estatus', ['activo','inactivo'])->default('activo');
        $table->date('fecha_registro');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empresas');
    }
};
