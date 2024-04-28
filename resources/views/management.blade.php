@extends('layouts.app')

@section('content')

    <div class="container mt-5">
        <h1 class="text-center mb-5">Bienvenido a la aplicación de gestión</h1>
        @include('includes.messages')
        <div class="card mb-5">
            <div class="card-body">
                <h4 class="card-title">🧍 Usuarios</h4>
                <p class="card-text">
                    <a name="" id="" class="btn btn-primary mb-3" href="{{ route('users.index') }}" role="button">Ir a usuarios</a>
                    <a name="" id="" class="btn btn-primary mb-3" href="{{ route('index', app()->getLocale()) }}" role="button">Volver al Inicio</a>
                </p>
            </div>
        </div>

        <div class="card mb-5">
            <div class="card-body">
                <h4 class="card-title">🎉 Eventos</h4>
                <p class="card-text">
                    <a name="" id="" class="btn btn-primary" href="{{ route('events.index') }}" role="button">Ir a Eventos</a>
                </p>
            </div>
        </div>
    </div>
@endsection