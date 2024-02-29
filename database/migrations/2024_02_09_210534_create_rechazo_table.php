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
        Schema::create('rechazo', function (Blueprint $table) {
            $table->id();
            $table->string('motivo');
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
        Schema::dropIfExists('rechazo');
    }
};
