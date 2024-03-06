<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table("users")->insert([
            "name"=>"admin",
            "email"=>"admin@gmail.com",
            "password"=>password_hash("Csas1234",PASSWORD_BCRYPT),
            "fecha_nacimiento"=>"2001/03/05",
            "premiun"=>true,
            "redes"=>"www.twitter.com;www.facebook.com"
        ]);
        DB::table("users")->insert([
            "name"=>"usuario",
            "email"=>"usuario@gmail.com",
            "password"=>password_hash("Csas1234",PASSWORD_BCRYPT),
            "fecha_nacimiento"=>"2001/03/05",
            "premiun"=>false,
            "redes"=>null
        ]);
    }
}
