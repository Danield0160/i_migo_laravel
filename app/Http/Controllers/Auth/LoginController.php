<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Storage;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected function validateLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);
    }

    protected function attemptLogin(Request $request)
    {

        $user = User::where("active", 1)->where("email",$request->email)->first();

        if($user == null){
            session()->flash('error', 'Por favor introduzca un correo electrónico válido.');
            return redirect()->route('home');
        }

        if (!Hash::check($request->password, $user->password)) {
            session()->flash('error', 'Usuario o contraseña incorrectos.');
            return redirect()->route('home')->withInput();
        }

        if(!isset($user)){
            session()->flash('error', 'Usuario o contraseña incorrectos.');
            return redirect()->route('home')->withInput();
        }

        if($user->verified == 0){
            session()->flash('error', 'Usuario no verificado.');
            return redirect()->route('home')->withInput();
        }

        Auth::login($user);
        session()->flash('success', 'Bienvenido, '.$user->name.'.');
        return true;
    }

    protected $redirectTo = '/';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    // Método para cerrar sesión
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        // Mostrar un mensaje de éxito
        session()->flash('success', 'Sesión cerrada con éxito.');

        return $this->loggedOut($request) ?: redirect('/');
    }
}
