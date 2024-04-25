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
            "event_id"=>1,
            "tag_id"=>1,
        ]);
        DB::table("event_tags")->insert([
            "event_id"=>2,
            "tag_id"=>2,
        ]);
        DB::table("event_tags")->insert([
            "event_id"=>3,
            "tag_id"=>3,
        ]);
        DB::table("event_tags")->insert([
            "event_id"=>3,
            "tag_id"=>4,
        ]);
    }
}
