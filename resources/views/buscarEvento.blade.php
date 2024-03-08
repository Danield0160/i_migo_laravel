@extends("components.layouts.app-imigo")

@section("slot")
    @guest
        No estas logueado
    @endguest

    @auth

    buscador

    @endauth

@endsection
