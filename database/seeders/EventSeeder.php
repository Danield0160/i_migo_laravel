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
        //lanzarote
        DB::table("events")->insert([
            "id_creador"=>1,
            "nombre"=>"evento 1",
            "descripcion"=>"descripcion 1",
            "imagen_id"=>1,
            // "asistentes"=>3,
            "limite_asistentes"=>50,
            "lat" =>28.956265,
            "lng" => -13.589889,
            "fecha"=>"2024-03-10 19:00",
            "patrocinado" =>false
        ]);
        DB::table("events")->insert([
            "id_creador"=>1,
            "nombre"=>"evento 2",
            "descripcion"=>"Esto es un evento de prueba",
            "imagen_id"=>1,
            // "asistentes"=>5,
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
            "imagen_id"=>1,
            // "asistentes"=>43,
            "limite_asistentes"=>50,
            "lat" =>28.971806,
            "lng" => -13.535099,
            "fecha"=>"2024-03-09 15:35:00",
            "patrocinado"=>false,
        ]);

        //demas islas
        DB::table("events")->insert([
            "id_creador" => 2,
            "nombre"=>"fuerteventura",
            "descripcion"=>"Fiestita",
            "imagen_id"=>1,
            // "asistentes"=>43,
            "limite_asistentes"=>50,
            "lat" =>28.349636364201963,
            "lng" => -14.005846468310567,
            "fecha"=>"2024-03-09 15:35:00",
            "patrocinado"=>false,
        ]);
        DB::table("events")->insert([
            "id_creador" => 2,
            "nombre"=>"gran canaria",
            "descripcion"=>"Fiestita",
            "imagen_id"=>1,
            // "asistentes"=>43,
            "limite_asistentes"=>50,
            "lat" =>27.906375287165528,
            "lng" => -15.579637972216817,
            "fecha"=>"2024-03-09 15:35:00",
            "patrocinado"=>false,
        ]);
        DB::table("events")->insert([
            "id_creador" => 2,
            "nombre"=>"Tenerife",
            "descripcion"=>"Fiestita en casa de Pedro",
            "imagen_id"=>1,
            // "asistentes"=>43,
            "limite_asistentes"=>50,
            "lat" =>28.248066551264127,
            "lng" => -16.576647249560565,
            "fecha"=>"2024-03-09 15:35:00",
            "patrocinado"=>false,
        ]);
        DB::table("events")->insert([
            "id_creador" => 2,
            "nombre"=>"Gomera",
            "descripcion"=>"Fiestita en casa de Pedro",
            "imagen_id"=>1,
            // "asistentes"=>43,
            "limite_asistentes"=>50,
            "lat" =>28.110066967136415,
            "lng" => -17.249559847216815,
            "fecha"=>"2024-03-09 15:35:00",
            "patrocinado"=>false,
        ]);
    }
}
