@extends("components.layouts.app-imigo")

@section("slot")
    @guest
        No estas logueado
    @endguest

    @auth

    <form method="POST" action="{{route('crea')}}" enctype="multipart/form-data">
        @csrf

        <label for="name">Nombre del evento</label>
        <input name="name" id="name" type="text" class="@error('name') is-invalid @enderror">
        <br>
        <label for="descripcion">Descripcion del evento</label>
        <input name="descripcion" id="descripcion" type="text" class="@error('descripcion') is-invalid @enderror">
        <br>
        <label for="limite">limite de asistentes</label>
        <input name="limite" id="limite" type="number" class="@error('limite') is-invalid @enderror" min=0>

        <label for="latitud" style="display: none">latitud</label>
        <input name="latitud" style="display: none" id="latitud" type="text" class="@error('latitud') is-invalid @enderror">

        <label for="longitud" style="display: none">longitud</label>
        <input name="longitud" style="display: none" id="longitud" type="text" class="@error('longitud') is-invalid @enderror">
        <br>
        <label for="fecha">fecha del evento</label>
        <input name="fecha" id="fecha" type="date" class="@error('fecha') is-invalid @enderror">
        <br>
        <label for="time">tiempo</label>
        <input name="time" id="time" type="time" class="@error('time') is-invalid @enderror">
        <br>
        <label for="patrocinado">patrocinio</label>
        <input name="patrocinado" id="patrocinado" type="checkbox" class="@error('patrocinado') is-invalid @enderror">
        <br>

        <label for="imagen">imagen</label>
        <input name="imagen" id="imagen" type="file" class="@error('imagen') is-invalid @enderror">

        <button type="submit">Enviar</button>
    </form>

    @endauth

@endsection
