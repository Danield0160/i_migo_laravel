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
        //
        Schema::table('users', function (Blueprint $table) {

            $table->bigInteger("profile_photo_id")->nullable();
            // $table->foreignId("profile_photo_id")->references("id")->on("photos")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

        Schema::dropColumns("users",['profile_photo_id']);


    }
};
