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
            [
                "creator_id" => 1,
                "name" => "Encuentro para tomar cerveza",
                "description" => "¿Te gustaría pasar un buen rato tomando cerveza con amigos? ¡Únete a nuestro encuentro en el bar del centro!",
                "imagen_id" => 1,
                "assistants_limit" => 50,
                "lat" => 28.956265,
                "lng" => -13.589889,
                "date" => "2024-05-10 19:00",
                "sponsored" => false
            ],
            [
                "creator_id" => 1,
                "name" => "Juegos de cartas",
                "description" => "¡Ven y pasa un rato divertido jugando a los juegos de cartas! ¡Todos son bienvenidos, ya seas novato o experto!",
                "imagen_id" => 1,
                "assistants_limit" => 10,
                "lat" => 28.956396402073384,
                "lng" => -13.579589321168632,
                "date" => "2024-05-05 16:00",
                "sponsored" => false
            ],
            [
                "creator_id" => 2,
                "name" => "Ejercicio al aire libre",
                "description" => "¡Únete a nuestro grupo de ejercicio al aire libre! Realizaremos una sesión de entrenamiento en el parque central.",
                "imagen_id" => 1,
                "assistants_limit" => 50,
                "lat" => 28.971806,
                "lng" => -13.535099,
                "date" => "2024-06-12 15:35:00",
                "sponsored" => false
            ],
            [
                "creator_id" => 2,
                "name" => "Senderismo en Fuerteventura",
                "description" => "¡Disfruta de un día explorando los hermosos paisajes de Fuerteventura! Trae tu mochila y únete a la aventura.",
                "imagen_id" => 1,
                "assistants_limit" => 50,
                "lat" => 28.349636364201963,
                "lng" => -14.005846468310567,
                "date" => "2024-04-30 10:35:00",
                "sponsored" => false
            ],
            [
                "creator_id" => 2,
                "name" => "Clase de cocina en Gran Canaria",
                "description" => "¿Te gustaría aprender a cocinar platos tradicionales canarios? Únete a nuestra clase de cocina en Gran Canaria y descubre nuevos sabores.",
                "imagen_id" => 1,
                "assistants_limit" => 50,
                "lat" => 27.906375287165528,
                "lng" => -15.579637972216817,
                "date" => "2024-05-19 15:00:00",
                "sponsored" => false
            ],
            [
                "creator_id" => 2,
                "name" => "Tour en Tenerife",
                "description" => "¡Explora los lugares más emblemáticos de Tenerife con nuestro tour guiado! Descubre la historia y la cultura de la isla mientras disfrutas de vistas impresionantes.",
                "imagen_id" => 1,
                "assistants_limit" => 50,
                "lat" => 28.248066551264127,
                "lng" => -16.576647249560565,
                "date" => "2024-05-09 11:15:00",
                "sponsored" => false
            ],
            [
                "creator_id" => 2,
                "name" => "Excursión en La Gomera",
                "description" => "¿Te gustaría descubrir la belleza natural de La Gomera? Únete a nuestra excursión y disfruta de un día inolvidable explorando la isla.",
                "imagen_id" => 1,
                "assistants_limit" => 50,
                "lat" => 28.110066967136415,
                "lng" => -17.249559847216815,
                "date" => "2024-05-10 09:35:00",
                "sponsored" => false
            ]

        ]);
    }
}