<!DOCTYPE html>
<html lang="en">
<head>
    @laravelPWA
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{asset('css/index.css')}}">
    <link rel="stylesheet" href="{{asset('css/lateral.css')}}">
    <link rel="stylesheet" href="{{asset('css/mapa.css')}}">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue@3.4.21/dist/vue.global.min.js"></script>
    <script>const { createApp, ref } = Vue</script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <script>API_KEY = '{{ env('API_KEY') }}'</script>
    <script type="text/javascript" src="{{asset('js/mapa.js')}}"></script>
    <script src="{{asset('js/menu_lateral.js')}}"></script>
    <title>{{ env('APP_NAME') }}</title>
</head>
<body>

    <div id="app">

        <div id="lateral-izq">
            <div id="drag_pad"><i class="fa-solid fa-grip-lines"></i></div>
            <div id="header_app">
                @include("ApplicationPage.partials.header_navbar_app")
            </div>

            <div id="cuerpo_app">
                <script>SELECTOR_IMAGENES_TEMPLATE = ` @include("ApplicationPage.partials.selector_imagenes") `</script>
                <script>POPUP_TEAMPLATE = `@include("ApplicationPage.partials.popup_component")`</script>


                <div id="buscarEventoSection"></div>
                <script>buscarEventoSectionApp(` @include('ApplicationPage.LeftSide.buscarEvento') `)</script>

                <div id="misEventoSection"></div>
                <script>misEventoSectionApp(` @include('ApplicationPage.LeftSide.misEventos') `)</script>

                <div id="crearEventoSection"></div>
                <script>crearEventoSectionApp(`@include('ApplicationPage.LeftSide.crearEvento')`)</script>

                <div id="perfilSection"></div>
                <script>crearProfileSectionApp(` @include("ApplicationPage.LeftSide.profile") `)</script>
            </div>
        </div>

        <div id="lateral-der">
            @include("ApplicationPage.RightSide.mapa_partial")
            <script>MapaHtmlterminadoDeCargar()</script>
        </div>

        <div id="modal" style="display: none">
            <div id="modal-content"></div>
        </div>
        <script>showEventAppObject = showEventApp.mount($("#modal-content")[0])</script>
    </div>
</body>
</html>


// <script>
//     console.log("npm run dev \n php artisan serve \n php artisan websockets:serve ")
// </script>
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

