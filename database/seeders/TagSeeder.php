<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table("tags")->insert([
            "categoria"=>"deporte",
        ]);
        DB::table("tags")->insert([
            "categoria"=>"musica",
        ]);
        DB::table("tags")->insert([
            "categoria"=>"comida",
        ]);
        DB::table("tags")->insert([
            "categoria"=>"juegos de mesa",
        ]);
        DB::table("tags")->insert([
            "categoria"=>"juegos de rol",
        ]);
        DB::table("tags")->insert([
            "categoria"=>"competicion",
        ]);
        DB::table("tags")->insert([
            "categoria"=>"apertura",
        ]);
        DB::table("tags")->insert([
            "categoria"=>"cultural",
        ]);
        DB::table("tags")->insert([
            "categoria"=>"friki",
        ]);
        DB::table("tags")->insert([
            "categoria"=>"arte",
        ]);
        DB::table("tags")->insert([
            "categoria"=>"fotografia",
        ]);
        DB::table("tags")->insert([
            "categoria"=>"baile",
        ]);
        DB::table("tags")->insert([
            "categoria"=>"cine",
        ]);
        DB::table("tags")->insert([
            "categoria"=>"Literatura",
        ]);
        DB::table("tags")->insert([
            "categoria"=>"moda",
        ]);
        DB::table("tags")->insert([
            "categoria"=>"conferencias",
        ]);
        DB::table("tags")->insert([
            "categoria"=>"comedia",
        ]);
        DB::table("tags")->insert([
            "categoria"=>"voluntariado",
        ]);
        DB::table("tags")->insert([
            "categoria"=>"ciclismo",
        ]);
        DB::table("tags")->insert([
            "categoria"=>"senderismo",
        ]);
        DB::table("tags")->insert([
            "categoria"=>"feria",
        ]);
        DB::table("tags")->insert([
            "categoria"=>"taller",
        ]);
        DB::table("tags")->insert([
            "categoria"=>"desfile",
        ]);
    }

}
