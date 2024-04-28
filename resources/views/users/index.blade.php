@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        @include('includes.messages')

        <!-- Formulario de filtro -->
        <form action="{{ route('users.index') }}" method="GET" class="mb-3">
            <div class="row">
                <div class="col-md-6">
                    <input type="text" name="search" class="form-control" placeholder="{{ __('messages.management.placeholder') }}" value="{{ request()->input('search') }}">
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
                        <th scope="col">{{ __('messages.surname') }}</th>
                        <th scope="col">{{ __('messages.dni') }}</th>
                        <th scope="col">{{ __('messages.email') }}</th>
                        <th scope="col">{{ __('messages.actions') }}</th>
                        <th scope="col">{{ __('messages.events') }}</th>
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
                                    <a href="{{ route('users.show', $user->id) }}" class="btn btn-outline-primary">👁️</a>
                                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-outline-secondary">✏️</a>
                                    <button type="submit" class="btn btn-outline-danger">🗑️</button>
                                </form>
                            </td>
                            <td>
                                <a href="{{ route('users.events', $user->id) }}" class="btn btn-outline-info">🎉</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-grid gap-2">
            <a name="" id="" class="btn btn-success" href="{{ route('users.create') }}" role="button">{{ __('messages.management.new_user') }}</a>
            <a name="" id="" class="btn btn-secondary" href="{{ route('management') }}" role="button">{{ __('messages.management.back') }}</a>
        </div>

    </div>
@endsection