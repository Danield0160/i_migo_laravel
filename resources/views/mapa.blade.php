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

        <?php
        echo $datos;
        echo "<script>console.log('asd')</script>"
        ?>

    </script>

</body>
</html>
