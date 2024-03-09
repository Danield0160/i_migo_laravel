@extends("components.layouts.app-imigo")

@section("slot")
    @guest
        No estas logueado
    @endguest

    @auth

    <input type="text">
    <div id="listado_eventos_visibles"></div>

    <script>setTimeout(()=>actualizar_listado_mapas_visibles(),350)</script>

    @endauth

@endsection
