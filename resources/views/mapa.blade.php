@php
    \Carbon\Carbon::setLocale('es');
@endphp
<!-- -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script type="text/javascript" src="{{asset('js/mapa.js')}}"></script>
    <link rel="stylesheet" href="{{asset('css/mapa.css')}}">
    <title>Document</title>
</head>
<body>
    <div id="map"></div>
    <div id="cuerpo">

        <!-- Por cada evento pasado como dato a la vista crea su marcador -->
        @foreach ($datos as $index=>$evento )
        <div id="content{{$index}}" class="evento" onclick="showEventDetails(this,{{$evento}})">
            <div class="icono"></div>
            <div class="contenido">
                <h2>{{$evento["nombre"]}}</h2>
                <img src="{{asset($evento['imagen'])}}" alt="Imagen del evento">
                <p>Asistentes: {{$evento["asistentes"]}}</p>
                <p>Fecha: {{\Carbon\Carbon::parse($evento["fecha"])->translatedFormat('j \d\e F G:i\h')}}</p>
            </div>
        </div>
        @endforeach


    </div>

    <!--Popup al clickar un evento -->
    <div id="modal" style="display: none;" onclick="ocultar(event)">
        <!-- div del centro -->
        <div id="modal-content">
            <!-- Aquí se mostrará la información del evento -->
        </div>
    </div>


    <script>
        (async () => {
            await CargadoMapa;
            @foreach ($datos as $index=>$evento )
            MapaGoogleObject.addCustomMarker(
                {{ $evento["lat"] }},
                {{ $evento["lng"] }},
                {{ "content". $index }},
            )
            @endforeach
        })()
    </script>


</body>
</html>