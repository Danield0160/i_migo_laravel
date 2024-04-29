@extends('layouts.app')

@section('content')

    <div class="container mt-5" style="padding: 20px ;" >
        <h1 class="text-center mb-5" >{{ __('messages.management.title') }}</h1>
        @include('includes.messages')
        <div class="card mb-5" style="display: inline-block; width:48%; text-align:center">
            <div class="card-body">
                <h4 class="card-title">🧍 {{ __('messages.management.users') }}</h4>
                <p class="card-text">
                    <a name="" id="" class="btn btn-primary mb-3" href="{{ route('users.index') }}" role="button">{{ __('messages.management.go_users') }}</a>
                </p>
            </div>
        </div>

        <div class="card mb-5" style="display: inline-block; width:48%; padding:8px; text-align:center">
            <div class="card-body">
                <h4 class="card-title">🎉 {{ __('messages.management.events') }}</h4>
                <p class="card-text">
                    <a name="" id="" class="btn btn-primary" href="{{ route('events.index') }}" role="button">{{ __('messages.management.go_events') }}</a>
                </p>
            </div>
        </div>

        <div class="card mb-5" style="border: 0">
            <div class="card-body" >
                <p class="card-text">
                    <a name="" style="width:100%" id="" class="btn btn-primary mb-3" href="{{ route('index') }}" role="button">{{ __('messages.management.back_index') }}</a>
                </p>
            </div>
        </div>
    </div>
@endsection