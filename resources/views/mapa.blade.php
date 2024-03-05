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
    <div id="content" onclick="console.log('asd')">LLLLLLLLLLLLLLLLLLLLLLLLL</div>
    <div id="cuerpo">
        @foreach ($datos as $index=>$evento )
        <div id="content{{$index}}" class="evento">
            <h2>{{$evento["nombre"]}}</h2>
            <p>{{$evento["descripcion"]}}</p>
        </div>
        @endforeach
    </div>

    <script type="text/javascript" src="{{asset('js/mapa.js')}}"></script>
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
