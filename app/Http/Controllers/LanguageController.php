<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function languageSwitch($language){
        session(["language" => $language]);
        return redirect()->back()->with(["language_switched" => $language]);
    }
}
