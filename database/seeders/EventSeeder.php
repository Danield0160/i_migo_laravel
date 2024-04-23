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
        DB::table("events")->insert([[
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
        ],
            [
                "id_creador" => 1,
                "nombre" => "Quedada para tomar cerveza",
                "descripcion" => "¿Te apetece pasar un buen rato tomando cerveza con amigos? ¡Únete a nuestra quedada en el bar del centro!",
                "imagen_id" => 1,
                "limite_asistentes" => 50,
                "lat" => 28.956265,
                "lng" => -13.589889,
                "fecha" => "2024-03-10 19:00",
                "patrocinado" => false
            ],
            [
                "id_creador" => 1,
                "nombre" => "Jugar a las cartas",
                "descripcion" => "¡Ven a pasar un rato divertido jugando a las cartas! No importa si eres novato o experto, ¡todos son bienvenidos!",
                "imagen_id" => 1,
                "limite_asistentes" => 10,
                "lat" => 28.956396402073384,
                "lng" => -13.579589321168632,
                "fecha" => "2024-05-05 16:00",
                "patrocinado" => false
            ],
            [
                "id_creador" => 2,
                "nombre" => "Hacer ejercicio",
                "descripcion" => "¡Únete a nuestro grupo de ejercicio al aire libre! Realizaremos una sesión de entrenamiento en el parque central.",
                "imagen_id" => 1,
                "limite_asistentes" => 50,
                "lat" => 28.971806,
                "lng" => -13.535099,
                "fecha" => "2024-04-12 15:35:00",
                "patrocinado" => false
            ],
            [
                "id_creador" => 2,
                "nombre" => "Senderismo en Fuerteventura",
                "descripcion" => "¡Vamos a disfrutar de un día explorando los hermosos paisajes de Fuerteventura! Trae tu mochila y únete a la aventura.",
                "imagen_id" => 1,
                "limite_asistentes" => 50,
                "lat" => 28.349636364201963,
                "lng" => -14.005846468310567,
                "fecha" => "2024-04-30 10:35:00",
                "patrocinado" => false
            ],
            [
                "id_creador" => 2,
                "nombre" => "Clase de cocina en Gran Canaria",
                "descripcion" => "¿Te gustaría aprender a cocinar platos tradicionales canarios? Únete a nuestra clase de cocina en Gran Canaria y descubre nuevos sabores.",
                "imagen_id" => 1,
                "limite_asistentes" => 50,
                "lat" => 27.906375287165528,
                "lng" => -15.579637972216817,
                "fecha" => "2024-03-09 15:00:00",
                "patrocinado" => false
            ],
            [
                "id_creador" => 2,
                "nombre" => "Tour en Tenerife",
                "descripcion" => "¡Explora los lugares más emblemáticos de Tenerife con nuestro tour guiado! Descubre la historia y la cultura de la isla mientras disfrutas de vistas impresionantes.",
                "imagen_id" => 1,
                "limite_asistentes" => 50,
                "lat" => 28.248066551264127,
                "lng" => -16.576647249560565,
                "fecha" => "2024-05-09 11:15:00",
                "patrocinado" => false
            ],
            [
                "id_creador" => 2,
                "nombre" => "Excursión en La Gomera",
                "descripcion" => "¿Te gustaría descubrir la belleza natural de La Gomera? Únete a nuestra excursión y disfruta de un día inolvidable explorando la isla.",
                "imagen_id" => 1,
                "limite_asistentes" => 50,
                "lat" => 28.110066967136415,
                "lng" => -17.249559847216815,
                "fecha" => "2024-05-10 09:35:00",
                "patrocinado" => false
            ]
        ]);
    }
}