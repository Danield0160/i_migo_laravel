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
        Schema::create('chat_usuarios', function (Blueprint $table) {
            $table->id(); // quitar
            $table->timestamps();
            $table->integer("id_chat");
            $table->integer("id_usuario");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chat_usuarios');
    }
};
