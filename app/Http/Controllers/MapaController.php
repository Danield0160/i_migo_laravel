<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Event;

class MapaController extends Controller
{
    public function index(){
        return view("mapa",["datos"=>Event::all()]);
    }

    public static function obtener_todos(){
        return Event::all();
    }
    public static function obtener_cercanos($lat,$lng,$dist){


        // foreach (Event::obtenerEventosCercanos($lat,$lng,$dist) as $key => $value) {
        //     debugbar()->info($value->nombre,$value->distancia);
        // }

        $nearEvents = Event::obtenerEventosCercanos($lat,$lng,$dist);

        return $nearEvents;
    }
};
