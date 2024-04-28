@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <form method="POST" action="{{ route('users.update', $user->id ) }}">
            @method('PUT')
            @csrf
            @include('includes.messages')
            <div class="row justify-content-center">
                <div class="col-md-3 mb-3">
                    <label class="form-label">{{ __('messages.name') }}</label>
                    <input type="text" class="form-control" name="name" value="{{ $user->name }}">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">{{ __('messages.surname') }}</label>
                    <input type="text" class="form-control" name="surname" value="{{ $user->surname }}">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">{{ __('messages.dni') }}</label>
                    <input type="text" class="form-control" name="dni" value="{{ $user->dni }}">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">{{ __('messages.email') }}</label>
                    <input type="text" class="form-control" name="email" value="{{ $user->email }}">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">{{ __('messages.password') }}</label>
                    <input type="password" class="form-control" name="pass" value="">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">{{ __('messages.password_confirmation') }}</label>
                    <input type="password" class="form-control" name="pass_check" value="">
                </div>
            </div>
            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-success" role="button">{{ __('messages.send') }}</button>
            </div>
        </form>

        <div class="d-grid gap-2 mt-3">
            <a class="btn btn-secondary" href="{{ $url ? $url : route('users.index') }}" role="button">{{ __('messages.management.back') }}</a>
        </div>

    </div>
@endsection