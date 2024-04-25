{{-- <script>console.log("npm run dev \n php artisan serve \n php artisan websockets:serve ")</script> --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{asset('css/index.css')}}">
    <link rel="stylesheet" href="{{asset('css/lateral.css')}}">
    <link rel="stylesheet" href="{{asset('css/mapa.css')}}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/vue@3.4.21/dist/vue.global.min.js"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/vue@2.5.16/dist/vue.js"></script> --}}
    {{-- <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script> --}}
    <script>const { createApp, ref } = Vue</script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <script type="text/javascript" src="{{asset('js/mapa.js')}}"></script>
    <script src="{{asset('js/menu_lateral.js')}}"></script>
    <title>Document</title>
</head>
<body>
{{-- {{debugbar()->info($datos[0]->id)}} --}}

    <div id="app">

        <div id="lateral-izq">
        <script>SELECTOR_IMAGENES_TEMPLATE = ` @include("ApplicationPage.partials.selector_imagenes") `</script>
        <script>POPUP_TEAMPLATE = `@include("ApplicationPage.partials.popup_component")`</script>

            @auth
                <div id="header_app">
                    @include("ApplicationPage.partials.header_navbar_app")
                </div>

                <div id="cuerpo_app">
                    <div id="buscarEventoSection"></div>
                    <script>buscarEventoSectionApp(` @include('ApplicationPage.LeftSide.buscarEvento') `)</script>

                    <div id="misEventoSection"></div>
                    <script>misEventoSectionApp(` @include('ApplicationPage.LeftSide.misEventos') `)</script>

                    <div id="crearEventoSection"></div>
                    <script>crearEventoSectionApp(`@include('ApplicationPage.LeftSide.crearEvento')`)</script>

                    <div id="perfilSection"></div>
                    <script>crearProfileSectionApp(` @include("ApplicationPage.LeftSide.profile") `)</script>
                </div>

            @endauth
            @guest
                // TODO:retocar este boton
                <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Iniciar Sesión</a></li>
            @endguest
        </div>

        <div id="lateral-der">
            @include("ApplicationPage.RightSide.mapa_partial")
            <script>MapaHtmlterminadoDeCargar()</script>
        </div>


    </div>
    @auth

    @endauth
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

// https://www.youtube.com/watch?v=8RL584c7EsI

// @vite('resources/js/app.js')
// <script>
// tempo = setTimeout(() => {
//     try {

//         window.Echo.channel('Actualizacion_evento').
//         listen("ActualizacionEvento",(e)=>{
//             console.log("actualizacion")
//             actualizar_datos()
//         })
//         console.log("cargado correcto")
//     } catch (error) {
//         console.log("fallo")
//         actualizar_datos()
//     }
// }, 5000);
// </script>

</html>
