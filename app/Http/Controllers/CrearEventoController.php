<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\MapaController;
use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Facades\Storage;

use App\Events\ActualizacionEvento;

class CrearEventoController extends Controller
{

    public function index(Request $request) {
        $latitud = $request->latitud ?$request->latitud :"null";
        $longitud = $request->longitud?$request->longitud:"null";
        $distancia = $request->distancia?$request->distancia:50;

        $mapa = new MapaController();
        return view("crearEvento",["datos"=>$mapa::obtener_cercanos($latitud,$longitud,$distancia),"posicion"=>["lat"=>$latitud,"lng"=>$longitud],"dst"=>$distancia]);

    }


    public function crearEvento(Request $request){
        $nombre = $request->input("name");
        $desc = $request->input("descripcion");
        $limite = $request->input("limite");
        $latitud = $request->input("latitud");
        $longitud = $request->input("longitud");
        $fecha = $request->input("fecha")." ".$request->input("time");
        $patrocinado = $request->input("patrocinado")?true:false;

        $request->validate(['imagen' => 'required|mimes:pdf,jpg,avif,png|max:2048',]);
        $imageName = time().'.'.$request->file("imagen")->extension();
        $request->file("imagen")->move(public_path('images/uploads'), $imageName);

        $imageName?null:$imageName="logo.png";


        $evento = new Event;
        $evento->id_creador = auth()->id();
        $evento->nombre = $nombre;
        $evento->descripcion = $desc;
        $evento->limite_asistentes = $limite;
        $evento->lat = $latitud;
        $evento->lng = $longitud;
        $evento->fecha = $fecha;
        $evento->imagen = $imageName;
        $evento->patrocinado = $patrocinado;
        $evento->save();

        $mapa = new MapaController();

        event(new ActualizacionEvento);

        // return back();
    }


    public function storeImage(Request $request){
        $request->validate([
            'file' => 'required|mimes:png,txt,xlx,xls,pdf|max:2048'
            ]);
        $imagen = $request.file("file_upload");
    }
}
