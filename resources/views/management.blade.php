@extends('layouts.app')

@section('content')

    <div class="container mt-5">
        <h1 class="text-center mb-5">🏠 Bienvenido a la aplicación de alquileres</h1>
        @include('includes.messages')
        <div class="card mb-5">
            <div class="card-body">
                <h4 class="card-title">🧍 Usuarios</h4>
                <p class="card-text">
                    <a name="" id="" class="btn btn-primary mb-3" href="{{ route('users.index') }}" role="button">Ir a usuarios</a>
                    @guest
                    <br>

                        <a name="" id="" class="btn btn-primary" href="{{ route('login') }}" role="button">Iniciar sersión</a>
                        <a class="btn btn-primary" href="{{ route('users.create') }}">Registrarse</a>
                        <a href="{{ route('users.verification') }}" class="btn btn-primary">Verificar Usuario</a>

                    @endguest
                    @auth
                    <br>
                    <a name="" id="" class="btn btn-primary" href="{{ route('dashboard') }}" role="button">Gestionar Perfil</a>
                    @endauth
                </p>
            </div>
        </div>

        <!-- AÑadir gestión eventos -->
@endsection