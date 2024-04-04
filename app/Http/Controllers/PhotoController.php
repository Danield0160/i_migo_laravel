<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use Illuminate\Http\Request;

class PhotoController extends Controller
{
    public static function obtener_fotos(){
        return Photo::obtener_fotos_de_usuario_actual();
    }

    public static function guardar_imagen(Request $request){
        $request->validate(['file_upload' => 'required|mimes:pdf,jpg,avif,png|max:2048',]);
        $imageName = time().'.'.$request->file("file_upload")->extension();
        $request->file("file_upload")->move(public_path('images/uploads'), $imageName);
        // $imageName?null:$imageName="logo.png";
        if($imageName == null){
            return;
        }

        $photo = new Photo;
        $photo->id_creador = $request->user()->id;
        $photo->ruta = $imageName;
        $photo->save();
    }
}
