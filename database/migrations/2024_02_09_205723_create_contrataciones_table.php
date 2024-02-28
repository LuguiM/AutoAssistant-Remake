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
        Schema::create('contrataciones', function (Blueprint $table) {
            $table->id();
            $table->string('tipo_servicio');
            $table->timestamp('fecha_contratacion');
            $table->text('comentario')->nullable();
            $table->string('direccion')->nullable();
            $table->unsignedBigInteger('servicio_id');
            $table->unsignedBigInteger('conductor_id');
            $table->unsignedBigInteger('mecanico_id');
            $table->unsignedBigInteger('estado_id');

            $table->foreign('servicio_id')->references('id')->on('servicios_mecanicos')->onDelete('cascade');
            $table->foreign('conductor_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('mecanico_id')->references('perfil_mecanico_id')
            ->on('servicios_mecanicos')->onDelete('cascade');
            $table->foreign('estado_id')->references('id')->on('estados')->onDelete('cascade');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contrataciones');
    }
};
