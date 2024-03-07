<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{asset('css/mapa.css')}}">
    <link rel="stylesheet" href="{{asset('css/lateral.css')}}">
    <title>Document</title>
</head>
<body>

    <div id="app">

        <div id="lateral-izq">
            <form method="POST" action="/crearEvento" enctype="multipart/form-data">
                @csrf

                <label for="name">Nombre del evento</label>
                <input name="name" id="name" type="text" class="@error('name') is-invalid @enderror">
                <br>
                <label for="descripcion">Descripcion del evento</label>
                <input name="descripcion" id="descripcion" type="text" class="@error('descripcion') is-invalid @enderror">
                <br>
                <label for="limite">limite de asistentes</label>
                <input name="limite" id="limite" type="number" class="@error('limite') is-invalid @enderror" min=0>
                <br>
                <label for="latitud">latitud</label>
                <input name="latitud" id="latitud" type="text" class="@error('latitud') is-invalid @enderror">
                <br>
                <label for="longitud">longitud</label>
                <input name="longitud" id="longitud" type="text" class="@error('longitud') is-invalid @enderror">
                <br>
                <label for="fecha">fecha del evento</label>
                <input name="fecha" id="fecha" type="date" class="@error('fecha') is-invalid @enderror">
                <br>
                <label for="patrocinado">patrocinio</label>
                <input name="patrocinado" id="patrocinado" type="checkbox" class="@error('patrocinado') is-invalid @enderror">
                <br>


                <label for="imagen">imagen</label>
                <input name="imagen" id="imagen" type="file" class="@error('imagen') is-invalid @enderror">

                <button type="submit">Evniar</button>
            </form>
            <img src="{{$imagen}}" alt="" width="50px" height="50px">
        </div>


        <div id="lateral-der">
            @include("partials.mapa_partial")
        </div>
    </div>

</body>
</html>
