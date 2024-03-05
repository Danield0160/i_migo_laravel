(g => { var h, a, k, p = "The Google Maps JavaScript API", c = "google", l = "importLibrary", q = "__ib__", m = document, b = window; b = b[c] || (b[c] = {}); var d = b.maps || (b.maps = {}), r = new Set, e = new URLSearchParams, u = () => h || (h = new Promise(async (f, n) => { await (a = m.createElement("script")); e.set("libraries", [...r] + ""); for (k in g) e.set(k.replace(/[A-Z]/g, t => "_" + t[0].toLowerCase()), g[k]); e.set("callback", c + ".maps." + q); a.src = `https://maps.${c}apis.com/maps/api/js?` + e; d[q] = f; a.onerror = () => h = n(Error(p + " could not load.")); a.nonce = m.querySelector("script[nonce]")?.nonce || ""; m.head.append(a) })); d[l] ? console.warn(p + " only loads once. Ignoring:", g) : d[l] = (f, ...n) => r.add(f) && u().then(() => d[l](f, ...n)) })
({ key: "AIzaSyCpXidrzQAhH3iexpn_QJl2D5emusyySzE", v: "weekly" });




class MapaGoogle{
    constructor(){
        this.mapa = new Mapa(document.getElementById("map"), {
            center: { lat: 28.956265, lng:  -13.589889 },
            zoom: 15,
        });
        google.maps.event.addListener(this.mapa, 'zoom_changed', this.actualizarIconoZoom.bind(this))


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

    actualizarIconoZoom(){
        if(this.mapa.getZoom()>179999){
            document.querySelectorAll(".evento").forEach(function(ele,key,array){
                ele.classList.remove("popup-bubble-zoom-out")
                ele.classList.remove("popup-bubble")
                ele.classList.add("popup-bubble-zoom-in")
            })
        }else if(this.mapa.getZoom()<15){
            document.querySelectorAll(".evento").forEach(function(ele,key,array){
                ele.classList.remove("popup-bubble-zoom-in")
                ele.classList.remove("popup-bubble")
                ele.classList.add("popup-bubble-zoom-out")
            })
        }else {
            document.querySelectorAll(".evento").forEach(function(ele,key,array){
                ele.classList.remove("popup-bubble-zoom-in")
                ele.classList.add("popup-bubble")
                ele.classList.remove("popup-bubble-zoom-out")
            })
        }
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

        // decorador de la burbuja (triangulo de abajo)
        const bubbleAnchor = document.createElement("div");
        bubbleAnchor.classList.add("popup-bubble-anchor");
        bubbleAnchor.appendChild(element);
        // contenedor del popup
        this.containerDiv = document.createElement("div");
        this.containerDiv.classList.add("popup-container");
        this.containerDiv.appendChild(bubbleAnchor);
        // el popup bloquea la interaccion con el mapa.
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
            Math.abs(divPosition.x) < 1100 && Math.abs(divPosition.y) < 1100 // originalmente 4000  , depende del tamaño de la pantalla
                ? "block"
                : "none";

        if (display === "block") {
            this.containerDiv.style.left = divPosition.x + "px";
            this.containerDiv.style.top = divPosition.y + "px";
            this.containerDiv.children[0].children[0].setAttribute("visible",1) // añade al div evento un atributo que marca si es visible en el mapa
        }

        if (this.containerDiv.style.display !== display) {
            this.containerDiv.style.display = display;
            this.containerDiv.children[0].children[0].setAttribute("visible",0)
        }
    }
    esVisible(){}
}
}

var resolver; // para guardar de forma extena la resolucion de la promesa
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
        resolver() // ya todo cargado, permite el paso a los elementos que requieran las importaciones
        // MapaGoogleObject.addMarker(28.959265,-13.589889,"nombre")
    }
);

function showEventDetails(div,datos) {
    var modal = document.getElementById('modal');
    var modalContent = document.getElementById('modal-content');
    var eventoDiv = div;

    // Copia el contenido del evento al modal
    modalContent.innerHTML = eventoDiv.innerHTML;

    // Agrega la descripción y el botón de unirse al modal
    var descripcion = document.createElement('p');
    descripcion.textContent = 'Descripción: ' + datos['descripcion'];
    modalContent.appendChild(descripcion);

    var unirseBtn = document.createElement('button');
    unirseBtn.textContent = 'Unirse';
    modalContent.appendChild(unirseBtn);

    // Muestra el modal
    modal.style.display = 'block';
}

function ocultar(event){
    event.target.id ==  "modal" ? event.target.style.display = "none": null
}


//https://developers.google.com/maps/documentation/javascript/examples/overlay-popup
//https://developers.google.com/maps/documentation/javascript/markers?hl=es-419
