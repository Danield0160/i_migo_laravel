<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\RedirectResponse;
use App\Http\Controllers\MapaController;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Photo;
use App\Models\Event_tag;
use App\Models\Event_user;
use Illuminate\Support\Facades\Storage;

use App\Events\ActualizacionEvento;

use function Symfony\Component\String\b;

class EventoController extends Controller
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

        $evento = new Event;
        $evento->id_creador = auth()->id();
        $evento->nombre = $nombre;
        $evento->descripcion = $desc;
        $evento->limite_asistentes = $limite;
        $evento->lat = $latitud;
        $evento->lng = $longitud;
        $evento->fecha = $fecha;
        $evento->patrocinado = $patrocinado;

        // $request->validate(['imagen' => 'required|mimes:pdf,jpg,avif,png|max:2048',]);
        // $imageName = time().'.'.$request->file("imagen")->extension();
        // $request->file("imagen")->move(public_path('images/uploads'), $imageName);
        // $imageName?null:$imageName="logo.png";

        // $photo = new Photo;
        // $photo->id_creador = $request->user()->id;
        // $photo->ruta = $imageName;
        // $photo->save();

        debugbar()->info($request);

        $evento->imagen_id = $request->imagen;
        $evento->save();


        if($request->get("tags")){
            foreach (explode(",",$request->get("tags")) as $key => $value) {
                $evento_tag = new Event_tag;
                $evento_tag->id_evento = $evento->id;
                $evento_tag->id_tag = $value;
                $evento_tag->save();
            }
        }


        // $mapa = new MapaController();
        event(new ActualizacionEvento);
        // return back();
    }


    public function obtenerEventosUnidos(){
        return Event::obtenerMisEventosUnidos();
    }

    public function obtenerEventosCreados(){
        return Event::obtenerMisEventosCreados();
    }


    public function unirse_a_evento(Request $request){

        $evento =Event::find($request->input("event_id"));
        if($evento->getAsistentesAttribute() >= $evento->limite_asistentes){
            throw \Illuminate\Validation\ValidationException::withMessages(["limite excedido"]);
        };


        $event_user = new Event_user;
        $event_user->event_id = $request->input("event_id");
        $event_user->user_id = auth()->id();
        $event_user->save();

    }

    public function salir_de_evento(Request $request){
        $event_user = Event_user::where("event_id","=", $request->input("event_id"))
            ->where("user_id","=",auth()->id())
            ->get()[0];
        $event_user->delete();
    }

    public function eliminar_evento(Request $request){
        $event = Event::where("id","=", $request->input("event_id"), "and", "user_id","=",auth()->id())->get()[0];
        $event->delete();
    }
}