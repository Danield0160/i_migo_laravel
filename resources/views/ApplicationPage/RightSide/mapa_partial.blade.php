@php
    \Carbon\Carbon::setLocale('es');
@endphp

<div id="map">
    {{-- <button id="getLocation">Obtener ubicación</button> --}}
</div>
<div id="map-elements">

    <div id="buscador_container">
        <button id="buttonGeolocation"><i class="fa-solid fa-location-crosshairs fa-xl"></i></button>
        <input type="text" id="buscador">
        <input id="distance" type="button" name="distance"  value="100km" index=0 onclick="this.value = ['25km','100km','250km'][this.getAttribute('index')%3];this.setAttribute('index', this.getAttribute('index')+1)">
        {{-- <input type="range" name="distance"  min="0" max="6" value="2" oninput="this.nextElementSibling.value = [5,25,50,75,100,150,250][this.value]"> --}}
        {{-- <output id="distance">50</output><span>km</span> --}}
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


