<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public static function obtener_todos(){
        return Tag::all();
    }
}
