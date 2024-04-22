<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TagController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MapaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\EventoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ActualizacionController;


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
Route::get("/app",function(){return view("ApplicationPage.app");})->name("app");


Route::controller(EventoController::class)->group(function () {
    Route::get("/api/MyJoinedEvents","obtenerEventosUnidos");
    Route::post("/api/JoinEvent","unirse_a_evento");
    Route::post("/api/LeaveEvent","salir_de_evento");

    Route::get("/api/MyCreatedEvents","obtenerEventosCreados");
    Route::post("/api/CrearEvento","crearEvento");
    Route::delete("/api/DeleteEvent","eliminar_evento");
});


Route::controller(UserController::class)->group(function () {
    Route::get("/api/MyProfile","obtener_mi_usuario");
    Route::get("/api/MyProfile/ChangePhoto/{id}","poner_foto_perfil"); //TODO ajustarlo para que sea post o put
});


Route::controller(PhotoController::class)->group(function () {
    Route::get("/api/MyPhotos","obtener_fotos");
    Route::get("/images/{id}","otbtener_imagen");
    Route::post("/api/uploadImage","guardar_imagen");
});


Route::get("/api/AllTags",[TagController::class,"obtener_todos"]);

Route::get("/api/NearEvents/{latitud}/{longitud}/{distancia}",[MapaController::class,"obtener_cercanos"]);

//ruta para websocket
Route::get("mensaje",[ActualizacionController::class,"mensaje"]);




/* Rutas de autenticación */

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/management', [HomeController::class, 'management'])->name('management');


Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
Route::post('/users', [UserController::class, 'store'])->name('users.store');

Route::get('/users/verification', [UserController::class, 'verification'])->name('users.verification');
Route::post('/users/verify', [UserController::class, 'verify'])->name('users.verify');

Route::group(['middleware' => 'auth'], function () {
    Route::resource('users', UserController::class)->except(['create', 'store']);
    Route::resource('events', EventController::class);
});


//TODO: probar a cambiarlos por url("x") en las vistas para no utilizar rutas
Route::get("/management", function(){return view("management");})->name("management");
Route::get("/dashboard", function(){return view("dashboard");})->name("dashboard");
Route::get("/dashboard", function(){return view("dashboard");})->name("dashboard");
Route::get("/profile.edit", function(){return view("profile.edit");})->name("profile.edit");
Route::get("/home", function(){return view("index");})->name("home");