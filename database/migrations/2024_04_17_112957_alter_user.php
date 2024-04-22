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
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('active')->nullable(false)->default(true);
            $table->boolean('verified')->nullable(false)->default(false);
            $table->boolean('admin')->nullable(false)->default(false);
            $table->string('dni')->nullable(false)->default('');
            $table->string('auth_code')->nullable(false)->default('');
            $table->string('surname')->nullable(false)->default('');
        });

        Schema::table('events', function (Blueprint $table) {
            $table->boolean('active')->nullable(false)->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('active');
            $table->dropColumn('verified');
            $table->dropColumn('admin');
            $table->dropColumn('dni');
            $table->dropColumn('auth_code');
            $table->dropColumn('surname');
        });
    }
};