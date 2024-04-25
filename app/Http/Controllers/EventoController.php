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

    public function createEvent(Request $request){

        $name = $request->input("name");
        $desc = $request->input("description");
        $limite = $request->input("limite");
        $latitud = $request->input("latitud");
        $longitud = $request->input("longitud");
        $date = $request->input("date")." ".$request->input("time");
        $sponsored = $request->input("sponsored")?true:false;

        $evento = new Event;
        $evento->creator_id = auth()->id();
        $evento->name = $name;
        $evento->description = $desc;
        $evento->asistence_limit = $limite;
        $evento->lat = $latitud;
        $evento->lng = $longitud;
        $evento->date = $date;
        $evento->sponsored = $sponsored;

        // $request->validate(['imagen' => 'required|mimes:pdf,jpg,avif,png|max:2048',]);
        // $imageName = time().'.'.$request->file("imagen")->extension();
        // $request->file("imagen")->move(public_path('images/uploads'), $imageName);
        // $imageName?null:$imageName="logo.png";

        // $photo = new Photo;
        // $photo->creator_id = $request->user()->id;
        // $photo->imagePath = $imageName;
        // $photo->save();

        debugbar()->info($request);

        $evento->imagen_id = $request->imagen;
        $evento->save();


        if($request->get("tags")){
            foreach (explode(",",$request->get("tags")) as $key => $value) {
                $evento_tag = new Event_tag;
                $evento_tag->event_id = $evento->id;
                $evento_tag->tag_id = $value;
                $evento_tag->save();
            }
        }


        // $mapa = new MapaController();
        event(new ActualizacionEvento); //websocket
        // return back();
    }

    public static function ObtainNearEvents($lat,$lng,$dist){

        // foreach (Event::obtainNearEvents($lat,$lng,$dist) as $key => $value) {
        //     debugbar()->info($value->name,$value->distancia);
        // }

        $nearEvents = Event::obtainNearEvents($lat,$lng,$dist);

        return $nearEvents;
    }


    public function obtainJoinedEvents(){
        return Event::obtainMyJoinedEvents();
    }

    public function obtainCreatedEvents(){
        return Event::obtainMyCreatedEvents();
    }


    public function joinEvent(Request $request){

        $evento =Event::find($request->input("event_id"));
        if($evento->getAsistentesAttribute() >= $evento->asistence_limit){
            throw \Illuminate\Validation\ValidationException::withMessages(["limite excedido"]);
        };


        $event_user = new Event_user;
        $event_user->event_id = $request->input("event_id");
        $event_user->user_id = auth()->id();
        $event_user->save();

    }

    public function leaveEvent(Request $request){
        $event_user = Event_user::where("event_id","=", $request->input("event_id"))
            ->where("user_id","=",auth()->id())
            ->get()[0];
        $event_user->delete();
    }

    public function deleteEvent(Request $request){
        $event = Event::where("id","=", $request->input("event_id"), "and", "user_id","=",auth()->id())->get()[0];
        $event->delete();
    }
}
