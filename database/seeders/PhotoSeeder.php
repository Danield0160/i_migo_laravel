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
            "creator_id"=>1,
            "imagePath"=>"logo.png"
        ]);
        DB::table("photos")->insert([
            "creator_id"=>2,
            "imagePath"=>"logo.png"
        ]);
    }
}
