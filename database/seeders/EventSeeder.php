<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table("events")->insert([
            "id_creador"=>1,
            "nombre"=>"evento 1",
            "descripcion"=>"descripcion 1",

            "asistentes"=>3,
            "limite_asistentes"=>50,
            "lat" =>28.956265,
            "lng" => -13.589889,
            "fecha"=>"2024-03-10 19:00:00",
            "patrocinado" =>false
        ]);
        DB::table("events")->insert([
            "id_creador"=>1,
            "nombre"=>"evento 2",
            "descripcion"=>"Esto es un evento de prueba",

            "asistentes"=>5,
            "limite_asistentes"=>10,
            "lat" =>28.956396402073384,
            "lng" => -13.579589321168632,
            "fecha"=>"2024-03-05 16:00:00",
            "patrocinado"=>false,
        ]);
        DB::table("events")->insert([
            "id_creador" => 2,
            "nombre"=>"Casa Pedro",
            "descripcion"=>"Fiestita en casa de Pedro",
            "imagen"=>"fiesta.png",
            "asistentes"=>43,
            "limite_asistentes"=>50,
            "lat" =>28.971806,
            "lng" => -13.535099,
            "fecha"=>"2024-03-09 15:35:00",
            "patrocinado"=>false,
        ]);
    }
}
