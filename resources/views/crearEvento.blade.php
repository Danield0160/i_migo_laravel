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
            <form method="POST" action="/crearEvento">
                @csrf

                <label for="title">Post Title</label>
                <input name="title" id="title" type="text" class="@error('title') is-invalid @enderror">

                <button type="submit">Evniar</button>
            </form>
        </div>


        <div id="lateral-der">
            @include("partials.mapa_partial")
        </div>
    </div>

</body>
</html>
