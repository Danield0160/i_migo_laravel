<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        DB::table("events")->insert([
            "nombre"=>"evento 1",
            "descripcion"=>"descripcion 1",
            "lat" =>28.956265,
            "lng" => -13.589889
        ]);
        DB::table("events")->insert([
            "nombre"=>"evento 2",
            "descripcion"=>"descripcion 2",
            "lat" =>28.956396402073384,
            "lng" => -13.579589321168632
        ]);
    }
}
