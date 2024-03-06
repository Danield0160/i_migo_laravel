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
            "categoria"=>"comida",
        ]);
        DB::table("tags")->insert([
            "categoria"=>"competicion",
        ]);
        DB::table("tags")->insert([
            "categoria"=>"apertura",
        ]);
    }
}
