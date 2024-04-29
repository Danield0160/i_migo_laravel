<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Event_users extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table("event_users")->insert([
            "event_id"=>3,
            "user_id"=>1,
        ]);
        DB::table("event_users")->insert([
            "event_id"=>3,
            "user_id"=>3,
        ]);
        DB::table("event_users")->insert([
            "event_id"=>3,
            "user_id"=>4,
        ]);
        DB::table("event_users")->insert([
            "event_id"=>3,
            "user_id"=>5,
        ]);
        DB::table("event_users")->insert([
            "event_id"=>3,
            "user_id"=>6,
        ]);
        DB::table("event_users")->insert([
            "event_id"=>3,
            "user_id"=>7,
        ]);
    }
}
