<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MapaContronller;
use App\Http\Controllers\CrearEventoController;
use App\Http\Controllers\UserController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {return redirect('index');});
Route::get('/index', function () {return view('index');});

Route::get('/mapa',[MapaContronller::class, "index"])->name("mapa");

Route::get('/login', function(){view("auth.login");});

Route::get("/crearEvento",[CrearEventoController::class,"index"])->name("crearEvento");
Route::post("/crearEvento",[CrearEventoController::class,"crearEvento"])->name("crearEvento");

require __DIR__.'/auth.php';



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Route::get("/setImage",[ImagenController::class,"storeImage"])->name("setImage");

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



// Navbar con boton de atras y con buscador
// js mapa, un boton que al clickar se le pegue al raton un icono, y que al hacer
    // click en el mapa lo suelte, y que de momento, te haga un console.log de
    // su latitud y longitud
// formulario crear evento
// formulario subir imagen