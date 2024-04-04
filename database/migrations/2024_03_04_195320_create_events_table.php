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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer("id_creador")->nullable();
            $table->string("nombre");
            $table->string("descripcion");
            $table->bigInteger("imagen_id")->nullable(); //cambiar por id
            $table->integer("asistentes")->default(0);
            $table->integer("limite_asistentes")->nullable();
            $table->double("lat");
            $table->double("lng");
            $table->datetime("fecha")->nullable();
            $table->boolean("patrocinado")->default(false);
            $table->integer("id_chat")->nullable();
            // $table->string("provincia");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
