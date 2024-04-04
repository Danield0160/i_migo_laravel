<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class PhotoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table("photos")->insert([
            "id_creador"=>1,
            "ruta"=>"logo.png"
        ]);
        DB::table("photos")->insert([
            "id_creador"=>2,
            "ruta"=>"logo.png"
        ]);
    }
}
