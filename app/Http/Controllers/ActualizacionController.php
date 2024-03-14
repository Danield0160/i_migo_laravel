<?php

namespace App\Http\Controllers;
use App\Events\ActualizacionEvento;
use Illuminate\Http\Request;

class ActualizacionController extends Controller
{
    public function mensaje(){
        event(new ActualizacionEvento);
    }
}
