<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;


class Photo extends Model
{
    use HasFactory;
    public static function obtener_fotos_de_usuario_actual(){
        return Photo::select(["id","ruta"])
        ->where("id_creador",Auth::user()->id)->get();
    }
}
