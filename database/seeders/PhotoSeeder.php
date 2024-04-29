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
            "creator_id"=>0,
            "imagePath"=>"logo.png"
        ]);
        DB::table("photos")->insert([
            "creator_id"=>2,
            "imagePath"=>"imagen1.png"
        ]);
        DB::table("photos")->insert([
            "creator_id"=>3,
            "imagePath"=>"imagen2.png"
        ]);
        DB::table("photos")->insert([
            "creator_id"=>4,
            "imagePath"=>"imagen3.png"
        ]);
        DB::table("photos")->insert([
            "creator_id"=>5,
            "imagePath"=>"imagen4.png"
        ]);
        DB::table("photos")->insert([
            "creator_id"=>6,
            "imagePath"=>"imagen5.png"
        ]);
    }
}
