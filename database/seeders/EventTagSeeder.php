<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EventTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table("event_tags")->insert([
            "id_evento"=>1,
            "id_tag"=>1,
        ]);
        DB::table("event_tags")->insert([
            "id_evento"=>2,
            "id_tag"=>2,
        ]);
        DB::table("event_tags")->insert([
            "id_evento"=>3,
            "id_tag"=>3,
        ]);
        DB::table("event_tags")->insert([
            "id_evento"=>3,
            "id_tag"=>4,
        ]);
    }
}
