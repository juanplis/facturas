<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up() {
    Schema::create('empresa', function (Blueprint $table) {
        $table->id();
        $table->string('razon_social', 100);
        $table->string('rif', 20)->unique();
        $table->string('telefono', 15);
        $table->enum('estatus', ['activo', 'inactivo'])->default('activo');
        $table->date('fecha_registro');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empresa');
    }
};
