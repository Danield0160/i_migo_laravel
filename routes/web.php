<?php

use App\Http\Controllers\ActualizacionController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MapaController;
use App\Http\Controllers\CrearEventoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BuscarEventoController;
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
Route::get('/index', function () {return view('index');})->name("index");

// Route::get("/crearEvento/lat:{latitud}_lng:{longitud}_dst:{distancia}",[CrearEventoController::class,"index"]);
// Route::get("/crearEvento/",[CrearEventoController::class,"index"])->name("crearEvento");


// Route::get("/buscarEvento/lat:{latitud}_lng:{longitud}_dst:{distancia}",[BuscarEventoController::class,"index"]);
// Route::get("/buscarEvento",[BuscarEventoController::class,"index"]);




Route::get("/app",function(){return view("app");})->name("app");
Route::get("/api/AllEvents",[MapaController::class,"obtener_todos"]);
Route::get("/api/NearEvents/{latitud}/{longitud}/{distancia}",[MapaController::class,"obtener_cercanos"]);
Route::post("/crearEvento",[CrearEventoController::class,"crearEvento"])->name("crea");

Route::get("mensaje",[ActualizacionController::class,"mensaje"]);

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


////TODO:
//! old
// Navbar con boton de atras y con buscador
// js mapa, un boton que al clickar se le pegue al raton un icono, y que al hacer
    // click en el mapa lo suelte, y que de momento, te haga un console.log de
    // su latitud y longitud
// formulario crear evento
// formulario subir imagen
// bbdd buscar por cercania
// session storage, al recargar se mantenga misma ubicacion de mapa
// css header-menu-app
// css footer-menu-app



//! new
//arreglar post crear evento
//seleccionar vue-app al clickar navbar
//hacer que el popup vaya por id en vez de copiar innerhtml
//websocket para refrescar eventos
// arreglar showEventDetail
//ajax buscar lugar
// hacer footer
//ocultar del mapa botones inutiles
//sistema de tags
//websocket, usar pusher o nodejs
//mis eventos
// terminar buscar evento, filtrar
//hacer perfil
//mapa cluster
//hacer que si no hay posicion inicial, pantalla pidiendo buscar lugar
//hacer que el obtener ubicacion sea un div en crear evento y que genere un minimapa propio
// click derecho en el mapa, "ubicar aqui"
//sistema de manejamiento de fotos, (para que no se repita la misma foto)
//modificar y eliminar eventos
//filtrado para unirte a eventos

//arreglar ip en otro ordenador para websocket y crear evento
//https
//boton para ocultar popups en crear Evento
//definir la estructura del menu y del submenu