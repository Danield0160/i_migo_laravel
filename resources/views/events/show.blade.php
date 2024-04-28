@extends('layouts.app')

@section('content')
    <div class="container mt-5">

        <div class="d-grid gap-2 mt-3">
            <p><b>{{ __('messages.name') }}: </b>{{ $event->name }}</p>
            <p><b>{{ __('messages.create_event.description') }}: </b>{{ $event->description }}</p>
            <p><b>{{ __('messages.create_event.assistants') }}: </b>{{ $event->asistentes }}</p>
            <p><b>{{ __('messages.create_event.max_people') }}: </b>{{ $event->assistants_limit }}</p>
            <p><b>{{ __('messages.create_event.sponsored') }}: </b>{{ $event->sponsored ? 'Sí' : 'No' }}</p>
            <p><b>{{ __('messages.create_event.date') }}: </b>{{ $event->date }}</p>
            <p><b>{{ __('messages.create_event.latitude') }}: </b>{{ $event->lat }}</p>
            <p><b>{{ __('messages.create_event.longitude') }}: </b>{{ $event->lng }}</p>
            <a class="btn btn-secondary" href="{{ $url ? $url : route('events.index') }}" role="button">{{ __('messages.management.back') }}</a>
        </div>
    </div>
@endsection
