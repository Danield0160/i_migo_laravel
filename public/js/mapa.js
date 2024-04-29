// cargado de la api
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
    key: API_KEY,
    v: "weekly"
});

// posicion del usuario, tanto geolocalizada o buscada
var geoposicionUsuario = {lat:28.95142318634212,lng:-13.605115900577536}; //posicion default

// promesa para detectar que se ha terminado de cargar e instanciar las clases
var terminadoDeCargar;
var AllLoaded = new Promise((success)=>terminadoDeCargar=success)

//clases, se estructura asi porque dentro se utiliza clases que se importan de forma asincrona
var AdvancedMarkerViewClass; // clase de los marcadores normales
var PopupClass; // clase de los marcadores personalizados

//instancia del mapa
var MapaGoogleObject;


//se estructura asi porque dentro se utiliza clases que se importan de forma asincrona
cargarMapaClass=()=>{
    // clase que representa al mapa
    return class MapaGoogle {
        marcadores = {}

        constructor() {
            this.mapa = new google.maps.Map(document.getElementById("map"), {
                center: geoposicionUsuario.lat? geoposicionUsuario : { lat: 28.9504656, lng: -13.589889 },
                zoom: 15,
                disableDefaultUI: true,
                mapTypeControl: false,

            });
            google.maps.event.addListener(this.mapa, 'zoom_changed', this.actualizarIconoZoom.bind(this))

            $("#buttonGeolocation").on("click",()=>{this.geolocalizar()})
            this.geolocalizar()

            //buscador de google
            this.autocompletado_input = new google.maps.places.SearchBox($("#buscador")[0])
            google.maps.event.addListener(this.autocompletado_input,"places_changed",()=>this.cambiarLugar())

            //boton para ubicar evento en crear evento
            this.buttonObtenerUbicacion = document.createElement("button");
            this.buttonObtenerUbicacion.textContent = "Obtener ubicación";
            this.buttonObtenerUbicacion.classList.add("custom-map-control-button");
            this.mapa.controls[google.maps.ControlPosition.TOP_CENTER].push(this.buttonObtenerUbicacion);
            this.estaObteniendoUbicacion=false
            this.buttonObtenerUbicacion.addEventListener("click", this.obtenerUbicacion.bind(this));

            //menu contextual
            this.mapa.addListener("contextmenu",(event)=>{
                this.crearMenuContextual(event.latLng.lat(),event.latLng.lng())
            })
        }
        // "evento" para que el usuario coja la ubicacion para la creacion de eventos
        crearMenuContextual(latitud,longitud){
            let div = document.createElement("div")
            let boton = document.createElement("button")
            boton.innerHTML = "ubicar aqui"
            boton.style.width = "100%"
            div.appendChild(boton)
            div.style.backgroundColor = "white"
            div.style.position = "relative"
            div.style.top = "-22px"
            div.style.left = "-10px"
            let popup = new PopupClass(new google.maps.LatLng(Number(latitud), Number(longitud)), div, false);
            popup.setMap(this.mapa)

            function quitar(){popup.remove();div.remove()}
            div.addEventListener("mouseleave",quitar)
            div.addEventListener("click",quitar)
            setTimeout(quitar,1500)

            div.onclick = ()=>{
                let ubicacion = new google.maps.LatLng(Number(latitud), Number(longitud))
                this.mapa.setCenter(ubicacion)
                geoposicionUsuario= {lat: latitud, lng:longitud}
                misEventoSectionAppObject.geoposicionUsuario = geoposicionUsuario
                buscarEventoSectionAppObject.actualizar_datos()
            }
        }

        obtenerUbicacion(){
            if(this.estaObteniendoUbicacion){return} //evita que actives dos veces lo mismo
            this.estaObteniendoUbicacion=true
            // limpia el mapa

            Object.keys(this.marcadores).forEach(id => {
                this.marcadores[id].popup.setMap(null);
            });


            // crea y añade al mapa el marcador que indica la posicion elegida
            if(!this.marker){
                this.marker = new AdvancedMarkerViewClass({
                    position: this.mapa.getCenter(),
                    map: this.mapa,
                    id:"marcador_de_ubicacion",
                    icon: 'https://maps.google.com/mapfiles/ms/icons/red-dot.png' // Use a custom icon
                });
            }else{
                // si ya existe simplemente lo activa
                this.marker.setMap(this.mapa)
            }

            // actualiza la posicion del marcador con el movimiento del raton
            this.mouseMoveListener = this.mapa.addListener('mousemove', function (event) {
                this.marker.setPosition(event.latLng);
            }.bind(this));

            // coloca el marcador cuando se clicka el mapa (o el propio raton)
            this.clickListeners = [];
            [this.mapa,this.marker].forEach((element) => {

                let temp = element.addListener('click', function (event) {
                    if(!this.estaObteniendoUbicacion ){return}
                    this.placeMarker(event.latLng);
                    this.eliminarEventosObtenerUbicacion()
                }.bind(this));
                this.clickListeners.push(temp)
            })
        }
        //elimina los listener de this.obtenerUbicacion
        eliminarEventosObtenerUbicacion(forzozo=false){
            //elimina del mapa el marcador, para cuando se envia o se cambia de pestaña
            if(forzozo && this.marker){this.marker.setMap(null)}
            if(!this.estaObteniendoUbicacion){return}
            this.estaObteniendoUbicacion = false
            google.maps.event.removeListener(this.mouseMoveListener)
            this.clickListeners.forEach(function(ele){
                google.maps.event.removeListener(ele)
            })
            //vuelve a poner en el mapa los eventos cercanos
            Object.keys(this.marcadores).forEach(id => {
                this.marcadores[id].popup.setMap(this.mapa);
            })
        }
        //lee el google.searchBox, cambia la ubicacion y actualiza los datos
        cambiarLugar(){ //TODO cambiar procedimiento a funcion
            let lugar = this.autocompletado_input.getPlaces()[0]
            geoposicionUsuario = {lat:lugar.geometry.location.lat(),lng:lugar.geometry.location.lng()}

            let bounds = new google.maps.LatLngBounds();
            bounds.union(lugar.geometry.viewport);
            this.mapa.fitBounds(bounds);

            buscarEventoSectionAppObject.actualizar_datos()
        }
        //clava el marcador en el mapa el marcador del "evento" obtener ubicacion de crear evento, y pone su posicion
        // en el formulario de creacion de evento
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
            return [location.lat(), location.lng()];
        }


        //crea un objeto evento, le asocia un objeto popup con un div pasado como parametro
        addCustomMarker(eventoObject) {
            this.estaObteniendoUbicacion? null : eventoObject.popup.setMap(this.mapa);
            this.marcadores[eventoObject.datos.id] = eventoObject
            eventoObject.popup.containerDiv.style.opacity = 0
            setTimeout(()=>{this.actualizarIconoZoom();eventoObject.popup.containerDiv.style.opacity = 1},20) //delay para que se actualize en base a zoom
        }

        //cambia la apariencia de los popups en base al zoom del mapa
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

        //coge la geolocalizacion, si falla, lo gestiona
        geolocalizar(){
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    (data)=>{
                        geoposicionUsuario.lat = data.coords.latitude
                        geoposicionUsuario.lng = data.coords.longitude
                        this.mapa.setCenter(geoposicionUsuario)
                    },
                    ()=>{
                        console.log("geolocalizacion desactivada")
                    }
                )
            } else {
                alert("geolocalizacion no soportado por el dispositivo")
            }
        }
    }
}



//se estructura asi porque dentro se utiliza clases que se importan de forma asincrona
cargarPopupClass = () => {
    return class PopupClass extends google.maps.OverlayView {
        position;
        containerDiv;
        constructor(position, div, id, hacerAnchor = true) {
            super();
            this.id = id
            this.position = {lat:position.lat(),lng:position.lng()};
            div.classList.add("popup-bubble");

            // decorador de la burbuja (triangulo de abajo)
            const bubbleAnchor = document.createElement("div");
            hacerAnchor?bubbleAnchor.classList.add("popup-bubble-anchor"):null;
            bubbleAnchor.appendChild(div);
            // contenedor del popup
            this.containerDiv = document.createElement("div");
            this.containerDiv.classList.add("popup-container");
            this.containerDiv.appendChild(bubbleAnchor);
            // el popup bloquea la interaccion con el mapa.
            PopupClass.preventMapHitsAndGesturesFrom(this.containerDiv);
        }
        /** Called when the popup is added to the map. */
        onAdd() {
            this.containerDiv.style.opacity = 0
            this.containerDiv.children[0].style.top = "-20px"

            this.getPanes().floatPane.appendChild(this.containerDiv);
            $(this.containerDiv).animate({opacity:1},300)
            $(this.containerDiv.children[0]).animate({top:0},300)
        }
        /** Called when the popup is removed from the map. */
        onRemove() {
            if (this.containerDiv.parentElement) {
                $(this.containerDiv.children[0]).animate({top:"-20px"},300)
                $(this.containerDiv).animate({opacity:0},300,function(){
                    this.containerDiv.parentElement.removeChild(this.containerDiv);
                }.bind(this))
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
        // comprueba si el popup esta dentro de la ventana del mapa
        esVisible() {
            if(this.map == null || this.getProjection() == null){
                return false
            }
            const divPosition = this.getProjection().fromLatLngToDivPixel(
                this.position,
            );
            // Hide the popup when it is far out of view.
            const display =
                Math.abs(divPosition.x) < $("#map")[0].getBoundingClientRect().width / 1.7 && Math.abs(divPosition.y) < $("#map")[0].getBoundingClientRect().height / 1.7 // originalmente 4000  , depende del tamaño de la pantalla
            // this.containerDiv.children[0].children[0].setAttribute("visible",display) // añade al div evento un atributo que marca si es visible en el mapa
            return display
        }
        //oculta del mapa
        remove(){
            this.setMap(null)
        }
        append(){
            if(this.map == null){ // hay que hacer esto por que si pones dos veces el evento, se quita en vez de seguir puesto
                this.setMap(MapaGoogleObject.mapa)
                setTimeout(()=>MapaGoogleObject.actualizarIconoZoom(),10)
            }
        }
        point(){
            this.containerDiv.children[0].children[0].classList.add("mostrando")
        }
        notPoint(){
            this.containerDiv.children[0].children[0].classList.remove("mostrando")
        }
        ubicar(event,eventos,ultimo_evento_mostrado){
            console.log(event)
            if(event.target.tagName == "BUTTON" || event.target.classList.contains("boton_participantes")){
                return
            }
            //si le vuelves a dar, se cancela la busqueda
            if(ultimo_evento_mostrado == this.id){
                Object.values(eventos).map((popup)=>{
                    popup.containerDiv.style.opacity = 1
                })
                return
            }
            //muestra el que se esta ubicando y oculta los que no
            Object.values(eventos).map((popup)=>{
                if(popup.id != this.id){
                    popup.containerDiv.style.opacity = 0.15
                }else{
                    popup.containerDiv.style.opacity = 1
                }
            })
            //ubica en el mapa
            MapaGoogleObject.mapa.setCenter(new google.maps.LatLng(Number(this.position.lat), Number(this.position.lng)))
        }
    }
}


var MapaHtmlterminadoDeCargar;
var MapaHtmlLoaded = new Promise((success)=>MapaHtmlterminadoDeCargar=success)
// importacion de las clases de la api
google.maps.importLibrary("maps").then(
    async () => {
        await MapaHtmlLoaded;
        AdvancedMarkerViewClass = google.maps.Marker;
        PopupClass = cargarPopupClass()


        google.maps.importLibrary("places").then(()=>{
            let MapaClass = cargarMapaClass()
            MapaGoogleObject = new MapaClass() // isntancia del objeto mapa
            terminadoDeCargar() // resolucion de la promesa de cargado
        })

    }
);



// funcion encargada de ocultar el overlay que se abre al clickar un popup
function ocultar(event) {
    event.target.id == "modal" ? event.target.style.display = "none" : null
}

function createPopup(eventoDatos){
        div = document.createElement("div")
        let eventoApp = createApp({
        data(){
            return {
                id:eventoDatos.id,
                datos:eventoDatos,
                // showEventAppObject:showEventAppObject,
                popup:null
            }
        },
        computed:{
        },
        method:{
        },
        //template para los div eventos del mapa
        template:POPUP_TEAMPLATE
    })
    let eventoObject = eventoApp.mount(div)
    eventoObject.popup= new PopupClass(new google.maps.LatLng(eventoDatos.lat, eventoDatos.lng), div.children[0], eventoDatos.id)

    return eventoObject
}