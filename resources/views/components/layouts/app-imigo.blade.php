<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{asset('css/mapa.css')}}">
    <link rel="stylesheet" href="{{asset('css/lateral.css')}}">
    <link rel="stylesheet" href="{{asset('css/index.css')}}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet"/>
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
<script src="{{asset('js/menu_lateral.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</html>
