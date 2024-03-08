<?php

namespace App\Http\Controllers;
use App\Http\Controllers\MapaController;
use Illuminate\Http\Request;

class BuscarEventoController extends Controller
{
    public function index(Request $request){
        $latitud = $request->latitud ?$request->latitud :"null";
        $longitud = $request->longitud?$request->longitud:"null";
        $distancia =$request->distancia?$request->distancia:"null";
        $mapa = new MapaController();
        return view("buscarEvento",["datos"=>$mapa::obtener_cercanos($latitud,$longitud,$distancia),"posicion"=>["lat"=>$latitud, "lng"=>$longitud],"dst"=>$distancia]);
    }
}
