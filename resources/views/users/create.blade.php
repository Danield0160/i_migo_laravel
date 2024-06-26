@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <form method="POST" action="{{ route('users.store') }}">
            @csrf
            @include('includes.messages')
            <div class="row justify-content-center">
                <div class="col-md-3 mb-3">
                    <label class="form-label">{{ __('messages.name') }}</label>
                    <input type="text" class="form-control" name="name" required>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">{{ __('messages.surname') }}</label>
                    <input type="text" class="form-control" name="surname" required>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">{{ __('messages.dni') }}</label>
                    <input type="text" class="form-control" name="dni" required>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">{{ __('messages.email') }}</label>
                    <input type="text" class="form-control" name="email" required>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">{{ __('messages.password') }}</label>
                    <input type="password" class="form-control" name="pass"  required>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">{{ __('messages.password_confirmation') }}</label>
                    <input type="password" class="form-control" name="pass_check" required>
                </div>
                <input type="hidden" name="role" value="admin">
            </div>
            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-success" role="button">{{ __('messages.send') }}</button>
            </div>
        </form>

        <div class="d-grid gap-2 mt-3">
            @auth
            <a class="btn btn-secondary" href="{{ route('users.index') }}" role="button">{{ __('messages.management.back') }}</a>
            @endauth
            @guest
            <a class="btn btn-secondary" href="{{ route('home') }}" role="button">{{ __('messages.management.back') }}</a>
            @endguest
        </div>

    </div>
@endsection