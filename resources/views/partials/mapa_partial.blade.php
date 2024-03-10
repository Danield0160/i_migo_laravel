<script type="text/javascript" src="{{asset('js/mapa.js')}}"></script>
@php
    \Carbon\Carbon::setLocale('es');
@endphp

<div id="map">
    {{-- <button id="getLocation">Obtener ubicación</button> --}}
</div>
<div id="map-elements">

    @include("partials.buscador_app")

    <!-- Por cada evento pasado como dato a la vista crea su marcador -->

</div>

<!--Popup al clickar un evento -->
<div id="modal" style="display: none;" onclick="ocultar(event)">
    <!-- div del centro -->
    <div id="modal-content">
        <!-- Aquí se mostrará la información del evento -->
    </div>
</div>


