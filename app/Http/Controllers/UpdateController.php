<?php

namespace App\Http\Controllers;
use App\Events\EventUpdate;
use Illuminate\Http\Request;

class UpdateController extends Controller
{
    public function message(){
        debugbar()->info("llamado a la imagePath");
        event(new EventUpdate);
    }
}
