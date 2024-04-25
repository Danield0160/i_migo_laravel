<?php

namespace App\Http\Controllers;
use App\Events\ActualizacionEvento;
use Illuminate\Http\Request;

// websocket actualizacion
class ActualizacionController extends Controller
{
    public function message(){
        debugbar()->info("llamado a la ruta");
        event(new ActualizacionEvento);
    }
}
