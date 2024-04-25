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
            "category_name"=>"deporte",
        ]);
        DB::table("tags")->insert([
            "category_name"=>"musica",
        ]);
        DB::table("tags")->insert([
            "category_name"=>"comida",
        ]);
        DB::table("tags")->insert([
            "category_name"=>"juegos de mesa",
        ]);
        DB::table("tags")->insert([
            "category_name"=>"juegos de rol",
        ]);
        DB::table("tags")->insert([
            "category_name"=>"competicion",
        ]);
        DB::table("tags")->insert([
            "category_name"=>"apertura",
        ]);
        DB::table("tags")->insert([
            "category_name"=>"cultural",
        ]);
        DB::table("tags")->insert([
            "category_name"=>"friki",
        ]);
        DB::table("tags")->insert([
            "category_name"=>"arte",
        ]);
        DB::table("tags")->insert([
            "category_name"=>"fotografia",
        ]);
        DB::table("tags")->insert([
            "category_name"=>"baile",
        ]);
        DB::table("tags")->insert([
            "category_name"=>"cine",
        ]);
        DB::table("tags")->insert([
            "category_name"=>"Literatura",
        ]);
        DB::table("tags")->insert([
            "category_name"=>"moda",
        ]);
        DB::table("tags")->insert([
            "category_name"=>"conferencias",
        ]);
        DB::table("tags")->insert([
            "category_name"=>"comedia",
        ]);
        DB::table("tags")->insert([
            "category_name"=>"voluntariado",
        ]);
        DB::table("tags")->insert([
            "category_name"=>"ciclismo",
        ]);
        DB::table("tags")->insert([
            "category_name"=>"senderismo",
        ]);
        DB::table("tags")->insert([
            "category_name"=>"feria",
        ]);
        DB::table("tags")->insert([
            "category_name"=>"taller",
        ]);
        DB::table("tags")->insert([
            "category_name"=>"desfile",
        ]);
    }

}
