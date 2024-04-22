<?php

namespace App\Http\Controllers;
use App\Events\ActualizacionEvento;
use Illuminate\Http\Request;

class ActualizacionController extends Controller
{
    public function mensaje(){
        debugbar()->info("llamado a la ruta");
        event(new ActualizacionEvento);
    }
}
