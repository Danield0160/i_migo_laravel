<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\MapaContronller;
use Illuminate\Http\Request;

class CrearEventoController extends Controller
{

    public function index() {
        $mapa = new MapaContronller();
        return view("crearEvento",["datos"=>$mapa::obtener_todos()]);
    }


    public function crearEvento(Request $request){
        debugbar()->info($request->input("title"));
        $mapa = new MapaContronller();

        return view("crearEvento",["datos"=>$mapa::obtener_todos()]);
    }


    public function storeImage(Request $request){
        $request->validate([
            'file' => 'required|mimes:png,txt,xlx,xls,pdf|max:2048'
            ]);
        $imagen = $request.file("file_upload");
    }
}
