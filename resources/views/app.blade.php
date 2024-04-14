<script>console.log("npm run dev \n php artisan serve \n php artisan websockets:serve ")</script>
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/vue@3.4.21/dist/vue.global.min.js"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/vue@2.5.16/dist/vue.js"></script> --}}
    {{-- <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script> --}}
    <script>const { createApp, ref } = Vue</script>
    <script>SELECTOR_IMAGENES_TEMPLATE = ` @include("partials.selector_imagenes") `</script>
    <title>Document</title>
</head>
<body>
{{-- {{debugbar()->info($datos[0]->id)}} --}}

    <div id="app">

        <div id="lateral-izq">
            @auth
                <div id="header_app">
                    @include("partials.header_navbar_app")
                </div>

                <div id="cuerpo_app">
                    <div id="buscarEventoSection"></div>
                    <div id="misEventoSection"></div>
                    <div id="crearEventoSection"></div>
                    <div id="perfilSection"></div>
                    <div></div>
                </div>

                <div id="footer_app"></div>
            @endauth
            @guest
                <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Inicia Sesión</a></li>
            @endguest
        </div>

        <div id="lateral-der">
            @include("partials.mapa_partial")
        </div>


    </div>
    @auth

    <script src="{{asset('js/menu_lateral.js')}}"></script>
    <script>buscarEventoSectionApp(` @include('buscarEvento') `)</script>
    <script>misEventoSectionApp(` @include('misEventos') `)</script>
    <script>crearEventoSectionApp(`@include('crearEvento')`)</script>
    <script>crearProfileSectionApp(` @include("partials.footer_profile_app") `)</script>
    @endauth
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

// https://www.youtube.com/watch?v=8RL584c7EsI

// @vite('resources/js/app.js')
// <script>
// setTimeout(() => {
//     try {

//         window.Echo.channel('Actualizacion_evento').
//         listen(".App\\Events\\ActualizacionEvento",(e)=>{
//             actualizar_datos()
//         })
//     } catch (error) {
//         actualizar_datos()
//     }
// }, 5000);
// </script>

</html>
