<?php

namespace App\Http\Controllers;

use Error;
use App\Models\User;
use App\Models\Event;
use App\Models\Event_tag;
use App\Models\Event_user;
use App\Mail\NewEventEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Events\ActualizacionEvento;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Mail;
use function Symfony\Component\String\b;
// websocket Event
class EventController extends Controller
{

    public function index(Request $request)
    {
        Log::channel('debugger')->info('Se ha accedido a la lista de usuarios.');

        $search = $request->input('search');
        $events = Event::get();


        if($search){
            $events = Event::where('name', 'like', '%'.$search.'%')
            ->orWhere('assistants_limit', 'like', '%'.$search.'%')
            ->get();
        }

        return view('events.index', compact('events'));
    }

    public function users(string $creator_id, Request $request)
    {

        $users = User::where('active', 1)->where('id', $creator_id)->get();

        return view('events.users', compact('users', 'creator_id'));
    }


    public function create(Request $request)
    {
        Log::channel('debugger')->info('Se ha accedido a la creación de un evento.');
        if (isset($request->error)){
            $error = $request->error;
            return view('events.create', compact('error'));
        }
        return view('events.create');
    }


    public function store(Request $request)
    {

        // Validar que la solicitud contenga todos los campos necesarios
        $requiredFields = ['name', 'description', 'assistants_limit', 'lat', 'lng', 'date'];

        foreach ($requiredFields as $field) {
            if (!$request->has($field)) {
                // Si falta algún campo, devuelve un error
                session()->flash('error', 'Por favor, rellena todos los campos.');
                return redirect()->route('events.create');
            }
        }

        DB::beginTransaction();

        // Obtener la ID del usuario autenticado
        $user = Auth::user();

        $role = $request->input('role');

        $event = Event::create([
            'creator_id' => $user->id, // ID del usuario creador
            'name' => $request->name, // Nombre del evento
            'description' => $request->description, // Descripción del evento
            'assistants' => 0, // Inicialmente no hay asistentes
            'assistants_limit' => $request->assistants_limit, // Límite de asistentes permitidos
            'lat' => $request->lat, // Latitud del lugar del evento
            'lng' => $request->lng, // Longitud del lugar del evento
            'date' => $request->date, // Fecha y hora del evento
            'sponsored' => false // Inicialmente no está sponsored
        ]);

        Mail::to(Auth::user()->email)->send(new NewEventEmail($user, $event));

        DB::commit();

        Log::channel('debugger')->info('Evento creado correctamente.');
        session()->flash('success', 'Evento creado correctamente.');
        return redirect()->route('events.index');

    }


    public function show(string $id, Request $request)
    {
        $url = $request->query('url');
        $event = Event::find($id);

        return view('events.show', compact('event', 'url'));
    }


    public function edit(string $id, Request $request)
    {
        $url = $request->query('url');
        $event = Event::find($id);

        return view('events.edit', compact('event', 'url'));
    }


    public function update(Request $request, string $id)
    {
        $event = Event::find($id);
        $event->name = $request->name;
        $event->description = $request->description;
        $event->assistants_limit = $request->assistants_limit;
        $event->lat = $request->lat;
        $event->lng = $request->lng;
        $event->date = $request->date;
        $event->sponsored = $request->has('sponsored'); // Asignar true si el campo está presente

        $event->save();

        session()->flash('info', 'Evento actualizado correctamente.');
        return redirect()->route('events.index');
    }

    public function destroy(string $id)
    {
        $event = Event::find($id);
        $event->delete();

        session()->flash('success', 'Evento eliminado correctamente.');
        return redirect()->route('events.index');
    }







    public function createEvent(Request $request){

        $name = $request->input("name");
        $desc = $request->input("description");
        $limite = $request->input("limite");
        $latitud = $request->input("latitud");
        $longitud = $request->input("longitud");
        $date = $request->input("date")." ".$request->input("time");
        $sponsored = $request->input("sponsored")?true:false;

        if(strtotime($date) < strtotime('now')){
            return Response::json(['error' => 'Tiene que ser una fecha futura'], 404);
        }

        $evento = new Event;
        $evento->creator_id = auth()->id();
        $evento->name = $name;
        $evento->description = $desc;
        $evento->assistants_limit = $limite;
        $evento->lat = $latitud;
        $evento->lng = $longitud;
        $evento->date = $date;
        $evento->sponsored = $sponsored;

        $evento->imagen_id = $request->imagen;
        $evento->save();


        if($request->get("tags")){
            foreach (explode(",",$request->get("tags")) as $key => $value) {
                $evento_tag = new Event_tag;
                $evento_tag->event_id = $evento->id;
                $evento_tag->tag_id = $value;
                $evento_tag->save();
            }
        }

        return $evento;
    }

    public static function ObtainNearEvents($lat,$lng,$dist){
        $nearEvents = Event::obtainNearEvents($lat,$lng,$dist);
        return $nearEvents;
    }


    public function obtainJoinedEvents(){
        return Event::obtainMyJoinedEvents();
    }

    public function obtainCreatedEvents(){
        return Event::obtainMyCreatedEvents();
    }

    public function joinEvent(Request $request){

        $evento =Event::find($request->input("event_id"));
        if($evento->getAsistentesAttribute() >= $evento->assistants_limit){
            throw \Illuminate\Validation\ValidationException::withMessages(["limite excedido"]);
        };


        $event_user = new Event_user;
        $event_user->event_id = $request->input("event_id");
        $event_user->user_id = auth()->id();
        $event_user->save();

    }

    public function leaveEvent(Request $request){
        $event_user = Event_user::where("event_id","=", $request->input("event_id"))
            ->where("user_id","=",auth()->id())
            ->get()[0];
        $event_user->delete();
    }

    public function deleteEvent(Request $request){
        $event = Event::where("id","=", $request->input("event_id"), "and", "user_id","=",auth()->id())->get()[0];
        $event->delete();
    }

    public function getJoinedUsers($eventId){
        $event = Event::where("id","=", $eventId, "and", "user_id","=",auth()->id())->get()[0];
        if($event == null){
            return Response::json(['error' => 'Error, no se ha encontrado el evento ']);
        }
        $users = Event_user::select("users.name","users.profile_photo_id")->join("users","users.id","=","event_users.user_id")->where("event_id", "=",$eventId)->get();
        return $users;

    }
}