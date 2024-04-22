@extends('layouts.app')

@section('content')
    <div class="container mt-5">

        <div class="d-grid gap-2 mt-3">
            <p><b>Nombre: </b>{{ $event->nombre }}</p>
            <p><b>Descripción: </b>{{ $event->descripcion }}</p>
            <p><b>Asistentes: </b>{{ $event->asistentes }}</p>
            <p><b>Límite de Asistentes: </b>{{ $event->limite_asistentes }}</p>
            <p><b>Patrocinado: </b>{{ $event->patrocinado ? 'Sí' : 'No' }}</p>
            <p><b>Fecha: </b>{{ $event->fecha }}</p>
            <a class="btn btn-secondary" href="{{ route('events.index') }}" role="button">Volver</a>
        </div>
    </div>
@endsection
