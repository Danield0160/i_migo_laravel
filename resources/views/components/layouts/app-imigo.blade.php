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
    <script src="https://cdn.jsdelivr.net/npm/vue@2.5.16/dist/vue.js"></script>
    <script src="https://unpkg.com/vue@3/dist/vue.global.js"></script><script>const { createApp, ref } = Vue</script>
    <script src="{{asset('js/menu_lateral.js')}}"></script>

    <title>Document</title>
</head>
<body>

{{-- {{debugbar()->info($datos[0]->id)}} --}}
<script>
    let datos_raw = <?php echo $datos; ?>;
    let datos={};
    datos_raw.forEach(function(val,index,arry){
        datos[val.id] = val;
    });
</script>
    <div id="app">

        <div id="lateral-izq">
            <div id="header_app">
                @include("partials.header_navbar_app")
            </div>

            <div id="cuerpo_app">
                @yield("slot")
                <div></div>
                <div></div>
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</html>
