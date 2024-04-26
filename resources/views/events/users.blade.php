@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        @include('includes.messages')

        <!-- Formulario de filtro -->
        <form action="{{ route('users.index', $creator_id) }}" method="GET" class="mb-3">
        </form>
        <div class="table-responsive">
            <table class="table table-dark">
                <thead>
                    <tr>
                        <th scope="col">Activo</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Apellidos</th>
                        <th scope="col">DNI</th>
                        <th scope="col">Email</th>
                        <th scope="col">Acciones</th>
                        <th scope="col">Eventos</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user )
                        <tr>
                            <td>
                                @if ($user->active)
                                    ✅
                                @else
                                    ❌
                                @endif
                            </td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->surname }}</td>
                            <td>{{ $user->dni }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" class="d-flex" id="delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <a href="{{ route('users.show', $user->id) }}?url={{ route('events.users', $creator_id) }}" class="btn btn-outline-primary">👁️</a>
                                    <a href="{{ route('users.edit', $user->id) }}?url={{ route('events.users', $creator_id) }}" class="btn btn-outline-secondary">✏️</a>
                                    <button type="submit" class="btn btn-outline-danger">🗑️</button>
                                </form>
                            </td>
                            <td>
                                <a href="{{ route('users.events', $user->id) }}?url={{ route('events.users', $creator_id) }}" class="btn btn-outline-info">🎉</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-grid gap-2">
            <a name="" id="" class="btn btn-secondary" href="{{ route('events.index') }}" role="button">Volver</a>
        </div>

    </div>
@endsection