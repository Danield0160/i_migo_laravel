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
            "surname"=>"admin",
            "dni"=>"12345678A",
            "email"=>"admin@gmail.com",
            "password"=>password_hash("Csas1234",PASSWORD_BCRYPT),
            "fecha_nacimiento"=>"2001/03/05",
            "premium"=>true,
            "redes"=>"www.twitter.com;www.facebook.com",
            "profile_photo_id"=>1,
            "verified" =>1,
            "admin" =>1
        ]);
        DB::table("users")->insert([
            [
                "name" => "Emma",
                "surname" => "Johnson",
                "dni" => "23456789D",
                "email" => "emma.johnson@example.com",
                "password" => password_hash("Password789", PASSWORD_BCRYPT),
                "fecha_nacimiento" => "1988/11/25",
                "premium" => true,
                "redes" => "www.twitter.com/emmajohnson;www.facebook.com/emmajohnson",
                "profile_photo_id" => 4,
                "verified" => 1,
                "admin" => 0
            ],
            [
                "name" => "Michael",
                "surname" => "Williams",
                "dni" => "34567890E",
                "email" => "michael.williams@example.com",
                "password" => password_hash("Password987", PASSWORD_BCRYPT),
                "fecha_nacimiento" => "1976/05/12",
                "premium" => false,
                "redes" => "www.twitter.com/michaelwilliams;www.facebook.com/michaelwilliams",
                "profile_photo_id" => 5,
                "verified" => 1,
                "admin" => 0
            ],
            [
                "name" => "Sophia",
                "surname" => "Brown",
                "dni" => "45678901F",
                "email" => "sophia.brown@example.com",
                "password" => password_hash("Password654", PASSWORD_BCRYPT),
                "fecha_nacimiento" => "1992/09/08",
                "premium" => true,
                "redes" => "www.twitter.com/sophiabrown;www.facebook.com/sophiabrown",
                "profile_photo_id" => 6,
                "verified" => 1,
                "admin" => 0
            ],
            [
                "name" => "James",
                "surname" => "Miller",
                "dni" => "56789012G",
                "email" => "james.miller@example.com",
                "password" => password_hash("Password321", PASSWORD_BCRYPT),
                "fecha_nacimiento" => "1985/03/17",
                "premium" => false,
                "redes" => "www.twitter.com/jamesmiller;www.facebook.com/jamesmiller",
                "profile_photo_id" => 7,
                "verified" => 1,
                "admin" => 0
            ],
            [
                "name" => "Olivia",
                "surname" => "Wilson",
                "dni" => "67890123H",
                "email" => "olivia.wilson@example.com",
                "password" => password_hash("Password012", PASSWORD_BCRYPT),
                "fecha_nacimiento" => "1998/07/30",
                "premium" => true,
                "redes" => "www.twitter.com/oliviawilson;www.facebook.com/oliviawilson",
                "profile_photo_id" => 8,
                "verified" => 1,
                "admin" => 0
            ]
        ]);
    }
}