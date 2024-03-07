<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\MapaContronller;
use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Facades\Storage;

class CrearEventoController extends Controller
{

    public function index() {
        $mapa = new MapaContronller();
        return view("crearEvento",["datos"=>$mapa::obtener_todos()]);
    }


    public function crearEvento(Request $request){
        $nombre = $request->input("name");
        $desc = $request->input("descripcion");
        $limite = $request->input("limite");
        $latitud = $request->input("latitud");
        $longitud = $request->input("longitud");
        $fecha = $request->input("fecha");
        $patrocinado = $request->input("patrocinado")?true:false;



        $request->validate([
            'imagen' => 'required|mimes:pdf,jpg,png|max:2048',
        ]);
        $file = $request->file("imagen");
        $filePath = $file->store("public/uploads");
        $name= $file->getBasename();

        // $evento = new Event;
        // $evento->id_creador = auth()->id();
        // $evento->nombre = $nombre;
        // $evento->descripcion = $desc;
        // $evento->limite_asistentes = $limite;
        // $evento->lat = $latitud;
        // $evento->lng = $longitud;
        // $evento->fecha = $fecha;
        // $evento->patrocinado = $patrocinado;

        // $evento->save();

        debugbar()->info([$nombre,$desc,$limite,$latitud,$longitud,$fecha,$patrocinado,
        storage_path($filePath),Storage::get($filePath),$file,$name]);
        $mapa = new MapaContronller();

        return view("crearEvento",["datos"=>$mapa::obtener_todos(),"imagen"=>Storage::get("fiesta.png")]);
    }


    public function storeImage(Request $request){
        $request->validate([
            'file' => 'required|mimes:png,txt,xlx,xls,pdf|max:2048'
            ]);
        $imagen = $request.file("file_upload");
    }
}
