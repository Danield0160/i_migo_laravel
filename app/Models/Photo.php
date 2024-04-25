<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;


class Photo extends Model
{
    use HasFactory;
    public static function obtainMyCurrentProfilePhoto(){
        return Photo::select(["id","imagePath"])
        ->where("creator_id",Auth::user()->id)->get();
    }
}
