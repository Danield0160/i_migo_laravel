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
            "asistentes"=>3,
            "fecha"=>"2024-03-10 19:00:00",
            "lat" =>28.956265,
            "lng" => -13.589889
        ]);
        DB::table("events")->insert([
            "nombre"=>"evento 2",
            "descripcion"=>"Esto es un evento de prueba",
            "asistentes"=>5,
            "fecha"=>"2024-03-05 16:00:00",
            "lat" =>28.956396402073384,
            "lng" => -13.579589321168632
        ]);
        DB::table("events")->insert([
            "nombre"=>"Casa Pedro",
            "descripcion"=>"Fiestita en casa de Pedro",
            "asistentes"=>43,
            "fecha"=>"2024-03-09 15:35:00",
            "imagen"=>"images/img_eventos/fiesta.png",
            "lat" =>28.971806,
            "lng" => -13.535099
        ]);
    }
}
