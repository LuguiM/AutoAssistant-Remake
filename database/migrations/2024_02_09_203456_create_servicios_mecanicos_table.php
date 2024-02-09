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
        Schema::create('servicios_mecanicos', function (Blueprint $table) {
            $table->id();
            $table->string('logo');
            $table->string('rubro');
            $table->string('servicio');
            $table->string('tipo_servicio');
            $table->text('descripcion');
            $table->string('dia_inicio');
            $table->string('dia_fin');
            $table->time('hora_apertura');
            $table->time('hora_cierre');
            $table->decimal('precio', 8, 2); // 8 dígitos en total, 2 decimales
            $table->decimal('precio_adomicilio', 8,2);
            $table->unsignedBigInteger('perfil_mecanico_id');
            $table->foreign('perfil_mecanico_id')->references('id')->on('perfil_mecanico')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('servicios_mecanicos');
    }
};
