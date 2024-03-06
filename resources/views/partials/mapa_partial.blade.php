<div id="map"></div>
<div id="map-elements">

    <!-- Por cada evento pasado como dato a la vista crea su marcador -->
    @foreach ($datos as $index=>$evento )
    <div id="content{{$index}}" class="evento" onclick="showEventDetails(this,{{$evento}})">
        <div class="icono"></div>
        <div class="contenido">
            <div class="contenido-imagen">
                <img src="{{asset($evento['imagen'])}}" alt="Imagen del evento">
            </div>
            <div class="contenido-datos">
                <h2><i>{{$evento["nombre"]}}</i></h2>
                <p><b>Fecha</b>: {{\Carbon\Carbon::parse($evento["fecha"])->translatedFormat('j \d\e F')}}</p>
                <p><b>Hora</b>: {{\Carbon\Carbon::parse($evento["fecha"])->format('H:i')}}</p>
                <p><b>Asistentes</b>: {{$evento["asistentes"]}}</p>
            </div>
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

