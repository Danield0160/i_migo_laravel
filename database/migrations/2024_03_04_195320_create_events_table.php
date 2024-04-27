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
            $table->integer("creator_id")->nullable();
            $table->string("name");
            $table->string("description");
            $table->bigInteger("imagen_id")->nullable();
            // $table->integer("asistentes")->default(0);
            $table->integer("assistants_limit")->nullable();
            $table->double("lat");
            $table->double("lng");
            $table->datetime("date")->nullable();
            $table->boolean("sponsored")->default(false);
            $table->integer("chat_id")->nullable();
            // $table->string("provincia");
            $table->softDeletes();
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
