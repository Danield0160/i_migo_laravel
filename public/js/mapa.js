(g => {
    var h, a, k, p = "The Google Maps JavaScript API",
        c = "google",
        l = "importLibrary",
        q = "__ib__",
        m = document,
        b = window;
    b = b[c] || (b[c] = {});
    var d = b.maps || (b.maps = {});
    var r = new Set,
        e = new URLSearchParams;
    var u = () => h || (h = new Promise(async (f, n) => {
        await (a = m.createElement("script"));
        e.set("libraries", [...r] + "");
        for (k in g) e.set(k.replace(/[A-Z]/g, t => "_" + t[0].toLowerCase()), g[k]);
        e.set("callback", c + ".maps." + q);
        a.src = `https://maps.${c}apis.com/maps/api/js?` + e;
        d[q] = f;
        a.onerror = () => h = n(Error(p + " could not load."));
        a.nonce = m.querySelector("script[nonce]")?.nonce || "";
        m.head.append(a)
    }));
    d[l] ? console.warn(p + " only loads once. Ignoring:", g) : d[l] = (f, ...n) => r.add(f) && u().then(() => d[l](f, ...n))
})({
    key: "AIzaSyCpXidrzQAhH3iexpn_QJl2D5emusyySzE",
    v: "weekly"
});

window.app = createApp({})
var posicion
class MapaGoogle {
    marcadores = []
    constructor() {
        // if(posicion.lat){
        // }
        // else{
            posicion ={ lat: 28.9504656, lng: -13.589889 }
            showPosition()
        // }
        this.mapa = new google.maps.Map(document.getElementById("map"), {
            center: posicion,
            zoom: 15,
        });
        setTimeout(()=>actualizar_listado_mapas_visibles(),500)

        // Wait for the map to be fully loaded before accessing its properties
        google.maps.event.addListenerOnce(this.mapa, 'idle', () => {
            google.maps.event.addListener(this.mapa, 'zoom_changed', this.actualizarIconoZoom.bind(this))

            const button = document.createElement("button");
            button.textContent = "Obtener ubicación";
            button.classList.add("custom-map-control-button");

            this.mapa.controls[google.maps.ControlPosition.TOP_CENTER].push(button);

            let eventoActivo=false
            button.addEventListener("click", function () {
                if(eventoActivo){return}
                eventoActivo=true
                // Remove all previous markers
                for (let i = 0; i < this.marcadores.length; i++) {
                    this.marcadores[i].setMap(null);
                }
                this.marcadores = [];

                // Create a marker at the center of the map
                this.marker = new AdvancedMarkerView({
                    position: this.mapa.getCenter(),
                    map: this.mapa,
                    id:"marcador_de_ubicacion",
                    icon: 'https://maps.google.com/mapfiles/ms/icons/red-dot.png' // Use a custom icon
                });
                this.marcadores.push(this.marker);

                // Update the marker position when the mouse moves
                this.mouseMoveListener = this.mapa.addListener('mousemove', function (event) {
                    this.marker.setPosition(event.latLng);
                }.bind(this));

                // Place the marker and remove the listeners when the map is clicked
                this.clickListener = [this.mapa,this.marker].forEach(element => {

                    element.addListener('click', function (event) {
                        if(!eventoActivo){return}
                        this.placeMarker(event.latLng);
                        eventoActivo=false
                        google.maps.event.removeListener(this.clickListener);
                        google.maps.event.removeListener(this.mouseMoveListener);

                    }.bind(this));
                });
            }.bind(this));
        });
    }
    placeMarker(location) {
        if (this.marker) {
            this.marker.setPosition(location);
        } else {
            this.marker = new google.maps.Marker({
                position: location,
                map: this.mapa
            });
        }
        document.getElementById('latitud').value = location.lat();
        document.getElementById('longitud').value = location.lng();
        console.log([location.lat(), location.lng()])
        return [location.lat(), location.lng()];
    }

    addMarker(lat, lng, nombre, titutlo_hover, icono = null) {
        const marker = new AdvancedMarkerView({
            map: this.mapa,
            position: {
                lat: lat,
                lng: lng
            },
            title: titutlo_hover,
            label: nombre,
            icon: icono,
        });
    }

    addCustomMarker(lat, lng, div,id) {
        let popup = new Popup(new google.maps.LatLng(lat, lng), div);
        popup.id = id
        popup.setMap(this.mapa);
        this.marcadores.push(popup)
    }

    actualizarIconoZoom() {
        if (this.mapa.getZoom() > 179999) {
            document.querySelectorAll(".evento").forEach(function (ele, key, array) {
                ele.classList.remove("popup-bubble-zoom-out")
                ele.classList.remove("popup-bubble")
                ele.classList.add("popup-bubble-zoom-in")
            })
        } else if (this.mapa.getZoom() < 13) {
            document.querySelectorAll(".evento").forEach(function (ele, key, array) {
                ele.classList.remove("popup-bubble-zoom-in")
                ele.classList.remove("popup-bubble")
                ele.classList.add("popup-bubble-zoom-out")
            })
        } else {
            document.querySelectorAll(".evento").forEach(function (ele, key, array) {
                ele.classList.remove("popup-bubble-zoom-in")
                ele.classList.add("popup-bubble")
                ele.classList.remove("popup-bubble-zoom-out")
            })
        }
    }
    obtenerPopusVisibles() {
        let popupsVisibles = []
        for (let popup of this.marcadores) {
            if (popup.esVisible()) {
                popupsVisibles.push(popup)
            }
        }
        return popupsVisibles
    }
    actualizarMedianteArrastrado(){
        google.maps.event.addListenerOnce(this.mapa, 'idle', () => {
            setTimeout(actualizar_listado_mapas_visibles, 100)
        })
    }
}

cargarOverlayClass = () => {
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
                Math.abs(divPosition.x) < 4000 && Math.abs(divPosition.y) < 4000 ?
                "block" :
                "none";

            if (display === "block") {
                this.containerDiv.style.left = divPosition.x + "px";
                this.containerDiv.style.top = divPosition.y + "px";
            }

            if (this.containerDiv.style.display !== display) {
                this.containerDiv.style.display = display;
            }
        }
        esVisible() {
            const divPosition = this.getProjection().fromLatLngToDivPixel(
                this.position,
            );
            // Hide the popup when it is far out of view.
            const display =
                Math.abs(divPosition.x) < $("#map")[0].getBoundingClientRect().width / 1.7 && Math.abs(divPosition.y) < $("#map")[0].getBoundingClientRect().height / 1.7 // originalmente 4000  , depende del tamaño de la pantalla
            // this.containerDiv.children[0].children[0].setAttribute("visible",display) // añade al div evento un atributo que marca si es visible en el mapa
            return display
        }
    }
}

var resolver; // para guardar de forma extena la resolucion de la promesa
var CargadoMapa = new Promise((res) => {
    resolver = res
});
var Popup;
var Mapa;
var AdvancedMarkerView;
var MapaGoogleObject;
google.maps.importLibrary("maps").then(
    () => {
        Mapa = google.maps.Map;
        AdvancedMarkerView = google.maps.Marker;
        Popup = cargarOverlayClass()

        MapaGoogleObject = new MapaGoogle()
        resolver() // ya todo cargado, permite el paso a los elementos que requieran las importaciones
        // MapaGoogleObject.addMarker(28.959265,-13.589889,"nombre")



        google.maps.importLibrary("places").then(
            () => {
                console.log("importado places")
                let autocompletado_input = new google.maps.places.SearchBox($("#buscador")[0])

                google.maps.event.addListener(autocompletado_input,"places_changed",function(){
                    lugar = autocompletado_input.getPlaces()[0]
                    console.log(lugar)
                    posicion = {lat:lugar.geometry.location.lat(),lng:lugar.geometry.location.lng()}

                    bounds = new google.maps.LatLngBounds();
                    bounds.union(lugar.geometry.viewport);
                    MapaGoogleObject.mapa.fitBounds(bounds);

                    // showPosition(posicion)
                })

            }
        )


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

function ocultar(event) {
    event.target.id == "modal" ? event.target.style.display = "none" : null
}

//https://developers.google.com/maps/documentation/javascript/examples/overlay-popup
//https://developers.google.com/maps/documentation/javascript/markers?hl=es-419
//https://developers.google.com/maps/documentation/?hl=es_419#places


// navigator.geolocation.getCurrentPosition(()=>{});
// var posicion
// if(posicion.lat){
// }else{
//     getLocation()
// }


function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    } else {
    }
}
function showPosition(position) {
    // posicion.lat?null:posicion.lat=position.coords.latitude;
    // posicion.lng?null:posicion.lng=position.coords.longitude;

    // let barra = window.location.pathname.endsWith("/")?"":"/"

    // if(window.location.pathname.endsWith("Evento") | window.location.pathname.endsWith("Evento/")){
    //     window.location.assign(window.location.pathname+barra+"lat:"+posicion.lat+"_lng:"+posicion.lng+"_dst:"+$("#distance").val());
    // }else {
    //     window.location.replace("./"+"lat:"+posicion.lat+"_lng:"+posicion.lng+"_dst:"+$("#distance").val());
    // }
}

function actualizar_listado_mapas_visibles(){
    let popupsVisibles =MapaGoogleObject.obtenerPopusVisibles()
    let listado = document.getElementById("listado_eventos_visibles")
    listado.innerHTML = ""

    popupsVisibles.forEach(function(ele,index,arrya){
        let elemento = datos[ele.id]
        let div = document.createElement("div")
        let titulo = document.createElement("h2")
        titulo.innerText = elemento.nombre
        let desc = document.createElement("p")
        desc.innerText=elemento.descripcion
        div.popupId = ele.id


        div.appendChild(titulo)
        div.appendChild(desc)
        listado.append(div)
    })


    MapaGoogleObject.actualizarMedianteArrastrado()
}
var datos={};
$.get("./api/AllEvents",function(data){
    data.forEach(function(ele){
        datos[ele.id] = ele
    })
    data.forEach(function(ele){
        div = document.createElement("div")
        fecha = new Date(ele.fecha)
        div.innerHTML =`
        <div class="evento" onclick="console.log(this)">
        <div class="icono"></div>
        <div class="contenido">
            <div class="contenido-imagen">
                <img src="images/uploads/${ele.imagen}" alt="Imagen del evento">
            </div>
            <div class="contenido-datos">
                <h2><i>${ele.nombre}</i></h2>
                <p><b>Fecha:</b> ${fecha.toLocaleDateString("es-ES",{weekday:"long", year:"numeric",month:"long",day:"numeric"})}</p>
                <p><b>Hora:</b> ${fecha.getHours()} : ${String(fecha.getMinutes()).padStart("2","0")}</p>
                <p><b>Asistentes</b>: ${ele.asistentes} / ${ele.limite_asistentes}</p>
            </div>
        </div>
    </div>`
        MapaGoogleObject.addCustomMarker(ele.lat,ele.lng,div.children[0],ele.id)
    })
})