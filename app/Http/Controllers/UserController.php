<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Http\Controllers\Mail\NewUserEmail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;



class UserController extends Controller
{
    public static function obtener_mi_usuario(){
        return User::select(["name","id","premiun","profile_photo_id"])->where("id",Auth::user()->id)->get();
    }

    public static function poner_foto_perfil($id){
        $user = User::find(Auth::user()->id);
        $user->profile_photo_id = $id;
        $user->save();
    }




    public function index(Request $request)
    {
        Log::channel('debugger')->info('Se ha accedido a la lista de usuarios.');

        $search = $request->input('search');
        $users = User::where('active', 1)->get();


        if($search){
            $users = User::where('active', 1)->where('name', 'like', '%'.$search.'%')
            ->orWhere('surname', 'like', '%'.$search.'%')
            ->orWhere('dni', 'like', '%'.$search.'%')
            ->orWhere('email', 'like', '%'.$search.'%')
            ->get();
        }

        return view('users.index', compact('users'));
    }


    public function create(Request $request)
    {
        Log::channel('debugger')->info('Se ha accedido a la creación de un usuario.');
        if (isset($request->error)){
            $error = $request->error;
            return view('users.create', compact('error'));
        }
        return view('users.create');
    }


    public function store(Request $request)
    {
        DB::beginTransaction();

            if($request->pass == $request->pass_check){
                $auth_code = strval(rand(1000, 9999));

                $user = User::create([
                    'name' => $request->name,
                    'surname' => $request->surname,
                    'dni' => $request->dni,
                    'email' => $request->email,
                    'password' => $request->pass,
                    'auth_code' => $auth_code,
                ]);

                Mail::to($user->email)->send(new NewUserEmail($user, $auth_code));

        DB::commit();
            Log::channel('debugger')->info('Usuario creado correctamente.');

            session()->flash('success', 'Usuario creado correctamente.');
            return redirect()->route('users.index');
        } else {
            Log::channel('debugger')->warning('Las contraseñas no coinciden.');
            $error = 'Las contraseñas no coinciden';
            return redirect()->route('users.create', ['error' => $error]);
        }
    }


    public function show(string $id)
    {
        $user = User::find($id);
        return view('users.show', compact('user'));
    }


    public function edit(string $id)
    {
        $user = User::find($id);
        return view('users.edit', compact('user'));
    }


    public function update(Request $request, string $id)
    {
        $user = User::find($id);
        $user->name = $request->name;
        $user->surname = $request->surname;
        $user->dni = $request->dni;
        $user->email = $request->email;

        if($request->pass){
            if($request->pass == $request->pass_check){
                $user->password = $request->pass;
            } else {
                return redirect()->route('users.edit', $id);
            }
        }
        $user->save();
        session()->flash('info', 'Usuario actualizado correctamente.');
        return redirect()->route('users.index');
    }


    public function destroy(string $id)
    {
        $user = User::find($id);
        $user->active = 0;
        $user->save();
        session()->flash('success', 'Usuario eliminado correctamente.');
        return redirect()->route('users.index');
    }

    public function verification(Request $request)
    {
        if($request->email){
            if($this->validateUserAuthCode($request->email, $request->auth_code)){
                return redirect()->route('app');
            } else {
                return redirect()->route('users.verification');
            }
        }else{
            return view('users.verification');
        }
    }


    public function verify(Request $request)
    {
        if($this->validateUserAuthCode($request->email, $request->auth_code)){
            return redirect()->route('app');
        } else {
            return redirect()->route('users.verification');
        }
    }

    private function validateUserAuthCode($email, $auth_code)
    {
        $user = User::where('email', $email)->first();
            if($user){
                if($user->auth_code == $auth_code){
                    $user->verified = 1;
                    $user->save();

                    Auth::login($user);
                    session()->flash('success', 'Bienvenido, '.$user->name.'. Su usuario ha sido verificado correctamente.');
                    return true;
                } else {
                    session()->flash('error', 'Código de verificación incorrecto.');
                    return false;
                }
            } else {
                session()->flash('error', 'Usuario no encontrado.');
                return false;
            }
    }

}