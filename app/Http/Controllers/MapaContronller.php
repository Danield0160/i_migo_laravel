<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Event;

class MapaContronller extends Controller
{
    public function index(){
        return view("mapa",["datos"=>Event::all()]);
    }

    public static function obtener_todos(){
        return Event::all();
    }
};
