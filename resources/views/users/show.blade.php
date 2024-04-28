@extends('layouts.app')

@section('content')
    <div class="container mt-5">

        <div class="d-grid gap-2 mt-3">
            <p><b>{{ __('messages.name') }}: </b>{{ $user->name }}</p>
            <p><b>{{ __('messages.surname') }}: </b>{{ $user->surname }}</p>
            <p><b>{{ __('messages.dni') }}: </b>{{ $user->dni }}</p>
            <p><b>{{ __('messages.email') }}: </b>{{ $user->email }}</p>
            <a class="btn btn-secondary" href="{{ $url ? $url : route('users.index') }}" role="button">{{ __('messages.management.back') }}</a>
        </div>
    </div>
@endsection