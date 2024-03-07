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
            <div id="header_app">
                @include("partials.header_navbar_app")
            </div>

            <div id="cuerpo_app">
                @yield("slot")
            </div>

            <div id="footer_app">
                @include("partials.footer_navbar_app")
            </div>
        </div>

        <div id="lateral-der">
            @include("partials.mapa_partial")
        </div>
    </div>

</body>
</html>
