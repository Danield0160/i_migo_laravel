@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        @include('includes.messages')

        <!-- Formulario de filtro -->
        <form action="{{ route('events.index') }}" method="GET" class="mb-3">
            <div class="row">
                <div class="col-md-6">
                    <input type="text" name="search" class="form-control" placeholder="{{ __('messages.management.placeholder2') }}" value="{{ request()->input('search') }}">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary">{{ __('messages.management.search') }}</button>
                </div>
            </div>
        </form>
        <div class="table-responsive">
            <table class="table table-dark">
                <thead>
                    <tr>
                        <th scope="col">{{ __('messages.active') }}</th>
                        <th scope="col">{{ __('messages.name') }}</th>
                        <th scope="col">{{ __('messages.create_event.description') }}</th>
                        <th scope="col">{{ __('messages.create_event.assistants') }}</th>
                        <th scope="col">{{ __('messages.create_event.max_people') }}</th>
                        <th scope="col">{{ __('messages.create_event.sponsored') }}</th>
                        <th scope="col">{{ __('messages.create_event.date') }}</th>
                        <th scope="col">{{ __('messages.actions') }}</th>
                        <th scope="col">{{ __('messages.owner') }}</th>
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
                                    <a href="{{ route('events.show', $event->id) }}" class="btn btn-outline-primary">👁️</a>
                                    <a href="{{ route('events.edit', $event->id) }}" class="btn btn-outline-secondary">✏️</a>
                                    <button type="submit" class="btn btn-outline-danger">🗑️</button>
                                </form>
                            </td>
                            <td>
                                <a href="{{ route('events.users', $event->creator_id) }}" class="btn btn-outline-info">👥</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-grid gap-2">
            <a name="" id="" class="btn btn-success" href="{{ route('events.create') }}" role="button">{{ __('messages.management.new_event') }}</a>
            <a name="" id="" class="btn btn-secondary" href="{{ route('management') }}" role="button">{{ __('messages.management.back') }}</a>
        </div>

    </div>
@endsection
