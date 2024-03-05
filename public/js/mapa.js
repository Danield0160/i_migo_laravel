(g => { var h, a, k, p = "The Google Maps JavaScript API", c = "google", l = "importLibrary", q = "__ib__", m = document, b = window; b = b[c] || (b[c] = {}); var d = b.maps || (b.maps = {}), r = new Set, e = new URLSearchParams, u = () => h || (h = new Promise(async (f, n) => { await (a = m.createElement("script")); e.set("libraries", [...r] + ""); for (k in g) e.set(k.replace(/[A-Z]/g, t => "_" + t[0].toLowerCase()), g[k]); e.set("callback", c + ".maps." + q); a.src = `https://maps.${c}apis.com/maps/api/js?` + e; d[q] = f; a.onerror = () => h = n(Error(p + " could not load.")); a.nonce = m.querySelector("script[nonce]")?.nonce || ""; m.head.append(a) })); d[l] ? console.warn(p + " only loads once. Ignoring:", g) : d[l] = (f, ...n) => r.add(f) && u().then(() => d[l](f, ...n)) })
({ key: "AIzaSyCpXidrzQAhH3iexpn_QJl2D5emusyySzE", v: "weekly" });




class MapaGoogle{
    constructor(){
        this.mapa = new Mapa(document.getElementById("map"), {
            center: { lat: 28.956265, lng:  -13.589889 },
            zoom: 15,
        });
    }
    probando(asd){
        console.log(asd)
    }
    addMarker(lat, lng,nombre, titutlo_hover, icono=null) {
        const marker = new AdvancedMarkerView({
            map: this.mapa,
            position: {lat:lat,lng:lng},
            title: titutlo_hover,
            label: nombre,
            icon: icono,
        });
    }

    addCustomMarker(lat,lng, div){
        let popup = new Popup(new google.maps.LatLng(lat, lng), div);
        popup.setMap(this.mapa);
    }

}
cargarOverlayClass = ()=>{
return class Popup extends google.maps.OverlayView {
    position;
    containerDiv;
    constructor(position, element) {
        super();
        this.position = position;
        element.classList.add("popup-bubble");

        // This zero-height div is positioned at the bottom of the bubble.
        const bubbleAnchor = document.createElement("div");

        bubbleAnchor.classList.add("popup-bubble-anchor");
        bubbleAnchor.appendChild(element);
        // This zero-height div is positioned at the bottom of the tip.
        this.containerDiv = document.createElement("div");
        this.containerDiv.classList.add("popup-container");
        this.containerDiv.appendChild(bubbleAnchor);
        // Optionally stop clicks, etc., from bubbling up to the map.
        Popup.preventMapHitsAndGesturesFrom(this.containerDiv);
    }
    /** Called when the popup is added to the map. */
    onAdd() {
        this.getPanes().floatPane.appendChild(this.containerDiv);
    }
    /** Called when the popup is removed from the map. */
    onRemove() {
        if (this.containerDiv.parentElement) {
            this.containerDiv.parentElement.removeChild(this.containerDiv);
        }
    }
    /** Called each frame when the popup needs to draw itself. */
    draw() {
        const divPosition = this.getProjection().fromLatLngToDivPixel(
            this.position,
        );
        // Hide the popup when it is far out of view.
        const display =
            Math.abs(divPosition.x) < 4000 && Math.abs(divPosition.y) < 4000
                ? "block"
                : "none";

        if (display === "block") {
            this.containerDiv.style.left = divPosition.x + "px";
            this.containerDiv.style.top = divPosition.y + "px";
        }

        if (this.containerDiv.style.display !== display) {
            this.containerDiv.style.display = display;
        }
    }
}
}

var resolver;
var CargadoMapa= new Promise((res)=>{resolver = res});
var Popup;
var Mapa;
var AdvancedMarkerView;
var MapaGoogleObject;
google.maps.importLibrary("maps").then(
    ()=>{
        Mapa = google.maps.Map;
        AdvancedMarkerView = google.maps.Marker;
        Popup = cargarOverlayClass()


        MapaGoogleObject = new MapaGoogle()
        resolver()
        MapaGoogleObject.addMarker(28.959265,-13.589889,"nombre")
    }
);

function showEventDetails(index,datos) {
    var modal = document.getElementById('modal');
    var modalContent = document.getElementById('modal-content');
    var evento = document.getElementById('content' + index);

    // Copia el contenido del evento al modal
    modalContent.innerHTML = evento.innerHTML;

    // Agrega la descripción y el botón de unirse al modal
    var descripcion = document.createElement('p');
    descripcion.textContent = 'Descripción: ' + datos['descripcion'];
    modalContent.appendChild(descripcion);

    var unirseBtn = document.createElement('button');
    unirseBtn.textContent = 'Unirse';
    modalContent.appendChild(unirseBtn);

    // Muestra el modal
    modal.style.display = 'block';

    // Obtén el modal
    var modal = document.getElementById('modal');

    // Cuando el usuario hace clic en cualquier lugar fuera del contenido del modal, cierra el modal
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    }
}



//https://developers.google.com/maps/documentation/javascript/examples/overlay-popup
//https://developers.google.com/maps/documentation/javascript/markers?hl=es-419
