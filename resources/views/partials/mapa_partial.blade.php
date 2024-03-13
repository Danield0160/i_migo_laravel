<script type="text/javascript" src="{{asset('js/mapa.js')}}"></script>
@php
    \Carbon\Carbon::setLocale('es');
@endphp

<div id="map">
    {{-- <button id="getLocation">Obtener ubicación</button> --}}
</div>
<div id="map-elements">

    <div id="buscador_container">
        <button id="buttonGeolocation">geolocalizacion</button>
        <input type="text" id="buscador"><br>
        <input type="range" name="distance" id="distance" min="5" max="250" value="50" oninput="this.nextElementSibling.value = this.value">
        <output>50</output><span>km</span>
    </div>

    <!-- Por cada evento pasado como dato a la vista crea su marcador -->

</div>

<!--Popup al clickar un evento -->
<div id="modal" style="display: none;" onclick="ocultar(event)">
    <!-- div del centro -->
    <div id="modal-content">
        <!-- Aquí se mostrará la información del evento -->
    </div>
</div>


