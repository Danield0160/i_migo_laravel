<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TagController;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\PhotoController;
use App\Http\Controllers\EventoController;
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
Route::get("/app",function(){
    Artisan::call('events:update');
    session()->flash('status', 'Eventos actualizados correctamente.');
    return view("ApplicationPage.app");
})->name("app");


Route::controller(EventController::class)->group(function () {
    Route::get("/api/MyJoinedEvents","obtainJoinedEvents");
    Route::post("/api/JoinEvent","joinEvent");
    Route::post("/api/LeaveEvent","leaveEvent");

    Route::get("/api/MyCreatedEvents","obtainCreatedEvents");
    Route::post("/api/CreateEvent","createEvent");
    Route::delete("/api/DeleteEvent","deleteEvent");

    Route::get("/api/NearEvents/{latitud}/{longitud}/{distancia}","ObtainNearEvents");
});


Route::controller(UserController::class)->group(function () {
    Route::get("/api/MyProfile","obtainMyUser");
    Route::get("/api/MyProfile/ChangePhoto/{id}","updateProfilePhoto"); //TODO ajustarlo para que sea post o put
});


Route::controller(PhotoController::class)->group(function () {
    Route::get("/api/MyPhotos","obtainMyPhotos");
    Route::get("/images/{id}","ObtainImage");
    Route::post("/api/uploadImage","storeImage");
    Route::delete("/api/deleteImage","deleteImage");
});


Route::get("/api/AllTags",[TagController::class,"obtainAllTags"]);


//ruta para websocket
Route::get("/message",[ActualizacionController::class,"message"]);




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

//TODO:
//limitar tags
//eventos pasados ignorar
//editar eventos
//version movil
//refactorizar
//usuarios unidos
//eventos para cada section, para poner y quitar del mapa los acorder
//ajustar actualizar datos de todo, poner intervalo
//quitar show event details

//arreglar obtener ubi colocar marcador,
//arreglar si se añade evento mientras no se esta en buscar evento
//arreglar pinchar varias veces en obtener ubicacion

//limpieza de links
//validacion formulario
//hacer que no haga falta clickar en el boton obtener ubicacion

//mover metodos al popup, ubicar y señalar