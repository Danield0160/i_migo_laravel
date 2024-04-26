@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        @include('includes.messages')

        <!-- Formulario de filtro -->
        <form action="{{ route('users.events', $id) }}" method="GET" class="mb-3">
            <div class="row">
                <div class="col-md-6">
                    <input type="text" name="search" class="form-control" placeholder="Buscar por name, descripción, etc." value="{{ request()->input('search') }}">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary">Buscar</button>
                </div>
            </div>
        </form>
        <div class="table-responsive">
            <table class="table table-dark">
                <thead>
                    <tr>
                        <th scope="col">Activo</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Descripción</th>
                        <th scope="col">Asistentes</th>
                        <th scope="col">Límite de Asistentes</th>
                        <th scope="col">Patrocinado</th>
                        <th scope="col">Fecha</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($events as $event )
                        <tr>
                            <td>
                                @if ($event->active)
                                    ✅
                                @else
                                    ❌
                                @endif
                            </td>
                            <td>{{ $event->name }}</td>
                            <td>{{ $event->description }}</td>
                            <td>{{ $event->asistentes }}</td>
                            <td>{{ $event->assistants_limit }}</td>
                            <td>
                                @if ($event->sponsored)
                                    ✅
                                @else
                                    ❌
                                @endif
                            </td>
                            <td>{{ $event->date }}</td>
                            <td>
                                <form action="{{ route('events.destroy', $event->id) }}" method="POST" class="d-flex" id="delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <a href="{{ route('events.show', $event->id) }}?url={{ route('users.events', $id) }}" class="btn btn-outline-primary">👁️</a>
                                    <a href="{{ route('events.edit', $event->id) }}?url={{ route('users.events', $id) }}" class="btn btn-outline-secondary">✏️</a>
                                    <button type="submit" class="btn btn-outline-danger">🗑️</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-grid gap-2">
            <a name="" id="" class="btn btn-secondary" href="{{ $url ? $url : route('users.index') }}" role="button">Volver</a>
        </div>

    </div>
@endsection
