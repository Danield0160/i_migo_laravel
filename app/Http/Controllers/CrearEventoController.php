<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\RedirectResponse;

use Illuminate\Http\Request;

class CrearEventoController extends Controller
{

    public function index() {
        return view("crearEvento");
    }

    public function storeImage(Request $request){
        $request->validate([
            'file' => 'required|mimes:png,txt,xlx,xls,pdf|max:2048'
            ]);
        $imagen = $request.file("file_upload");
        debugbar()->info("asd");
    }
}
