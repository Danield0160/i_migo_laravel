<?php

namespace App\Http\Controllers;
use App\Http\Controllers\MapaController;
use Illuminate\Http\Request;

class BuscarEventoController extends Controller
{
    public function index(Request $request){
        $latitud = $request->latitud ?$request->latitud :"null";
        $longitud = $request->longitud?$request->longitud:"null";
        $mapa = new MapaController();
        return view("buscarEvento",["datos"=>$mapa::obtener_todos(),"posicion"=>["lat"=>$latitud, "lng"=>$longitud]]);
    }
}
