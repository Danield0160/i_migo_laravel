(g => { var h, a, k, p = "The Google Maps JavaScript API", c = "google", l = "importLibrary", q = "__ib__", m = document, b = window; b = b[c] || (b[c] = {}); var d = b.maps || (b.maps = {}), r = new Set, e = new URLSearchParams, u = () => h || (h = new Promise(async (f, n) => { await (a = m.createElement("script")); e.set("libraries", [...r] + ""); for (k in g) e.set(k.replace(/[A-Z]/g, t => "_" + t[0].toLowerCase()), g[k]); e.set("callback", c + ".maps." + q); a.src = `https://maps.${c}apis.com/maps/api/js?` + e; d[q] = f; a.onerror = () => h = n(Error(p + " could not load.")); a.nonce = m.querySelector("script[nonce]")?.nonce || ""; m.head.append(a) })); d[l] ? console.warn(p + " only loads once. Ignoring:", g) : d[l] = (f, ...n) => r.add(f) && u().then(() => d[l](f, ...n)) })
({ key: "AIzaSyCpXidrzQAhH3iexpn_QJl2D5emusyySzE", v: "weekly" });




class MapaGoogle{
    marcadores = []
    constructor(){
        this.mapa = new Mapa(document.getElementById("map"), {
            center: { lat: 28.956265, lng:  -13.589889 },
            zoom: 15,
        });
        google.maps.event.addListener(this.mapa, 'zoom_changed', this.actualizarIconoZoom.bind(this))
        // google.maps.event.addListener(this.mapa, 'drag', this.obtenerPopusVisibles.bind(this))


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
        this.marcadores.push(popup)
    }

    actualizarIconoZoom(){
        if(this.mapa.getZoom()>179999){
            document.querySelectorAll(".evento").forEach(function(ele,key,array){
                ele.classList.remove("popup-bubble-zoom-out")
                ele.classList.remove("popup-bubble")
                ele.classList.add("popup-bubble-zoom-in")
            })
        }else if(this.mapa.getZoom()<13){
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
    obtenerPopusVisibles(){
        let popupsVisibles = []
        for (let popup of this.marcadores) {
            if (popup.esVisible()){
                popupsVisibles.push(popup)
            }
        }
        return popupsVisibles
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
    esVisible(){
        const divPosition = this.getProjection().fromLatLngToDivPixel(
            this.position,
        );
        // Hide the popup when it is far out of view.
        const display =
            Math.abs(divPosition.x) < window.innerWidth/1.7 && Math.abs(divPosition.y) < window.innerHeight/2 // originalmente 4000  , depende del tamaño de la pantalla
            // this.containerDiv.children[0].children[0].setAttribute("visible",display) // añade al div evento un atributo que marca si es visible en el mapa
        return display
    }
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

function showEventDetails(div, datos) {
    var modal = document.getElementById('modal');
    var modalContent = document.getElementById('modal-content');
    var eventoDiv = div;

    // Copia el contenido del evento al modal
    modalContent.innerHTML = eventoDiv.innerHTML;

    // Selecciona el div contenido-datos dentro del modalContent
    var contenidoDatosDiv = modalContent.querySelector('.contenido-datos');

    // Agrega la descripción y el botón de unirse al div contenido-datos
    var descripcion = document.createElement('p');
    var descripcionTexto = document.createElement('span');
    descripcion.textContent = 'Descripción: ';
    descripcionTexto.textContent = datos['descripcion'];

    // Establece el estilo de la descripción a negrita y el texto de descripción a cursiva
    descripcion.style.fontWeight = 'bold';
    descripcionTexto.style.fontStyle = 'italic';

    contenidoDatosDiv.appendChild(descripcion);
    contenidoDatosDiv.appendChild(descripcionTexto);

    var unirseBtn = document.createElement('button');
    unirseBtn.textContent = 'Unirse';
    contenidoDatosDiv.appendChild(unirseBtn);

    // Muestra el modal
    modal.style.display = 'block';
}

function ocultar(event){
    event.target.id ==  "modal" ? event.target.style.display = "none": null
}


//https://developers.google.com/maps/documentation/javascript/examples/overlay-popup
//https://developers.google.com/maps/documentation/javascript/markers?hl=es-419

//https://developers.google.com/maps/documentation/?hl=es_419#places