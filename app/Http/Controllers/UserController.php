<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public static function obtener_mi_usuario(){
        return User::select(["name","id","premiun","profile_photo_id"])->where("id",Auth::user()->id)->get();
    }

    public static function poner_foto_perfil($id){
        debugbar()->info("a");
        debugbar()->info(User::find(Auth::user()->id)->profile_photo_id);

        $user = User::find(Auth::user()->id);
        $user->profile_photo_id = $id;
        $user->save();


        debugbar()->info(User::find(Auth::user()->id)->profile_photo_id);
    }
}
