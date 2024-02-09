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
            $table->string('nombre_conductor');
            $table->string('nombre_servicio');
            $table->string('tipo_servicio');
            $table->timestamp('fecha_contratacion');
            $table->string('direccion')->nullable();
            $table->unsignedBigInteger('solicitud_contratacion_id');
            $table->foreign('solicitud_contratacion_id')->references('id')->on('solicitud_contratacion')->onDelete('cascade');

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
