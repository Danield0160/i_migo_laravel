<div id="buscador_container">
    <input type="text" id="buscador"><br>
    <input type="range" name="distance" id="distance" min="5" max="250" value="{{0}}" oninput="this.nextElementSibling.value = this.value">
    <output>{{0}}</output><span>km</span>
</div>
<script type="text/javascript" src="{{asset('js/buscador.js')}}"></script>