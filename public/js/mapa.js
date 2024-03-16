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
    key: "AIzaSyCpXidrzQAhH3iexpn_QJl2D5emusyySzE",
    v: "weekly"
});

// posicion del usuario, tanto geolocalizada o buscada
var geoposicionUsuario = {lat:28.95142318634212,lng:-13.605115900577536}; //posicion default
//! var datos={}; // datos en crudo que se recibe del servidor

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
                mapTypeControl: true,

            });
            google.maps.event.addListener(this.mapa, 'zoom_changed', this.actualizarIconoZoom.bind(this))

            $("#buttonGeolocation").on("click",()=>{this.geolocalizar()})
            this.geolocalizar()

            this.autocompletado_input = new google.maps.places.SearchBox($("#buscador")[0])
            google.maps.event.addListener(this.autocompletado_input,"places_changed",()=>this.cambiarLugar())

            setTimeout(()=>actualizar_listado_popus_visibles(),800)


            this.buttonObtenerUbicacion = document.createElement("button");
            this.buttonObtenerUbicacion.textContent = "Obtener ubicación";
            this.buttonObtenerUbicacion.classList.add("custom-map-control-button");
            this.mapa.controls[google.maps.ControlPosition.TOP_CENTER].push(this.buttonObtenerUbicacion);
            this.estaObteniendoUbicacion=false
            this.buttonObtenerUbicacion.addEventListener("click", this.obtenerUbicacion.bind(this));

            //menu contextual
            this.mapa.addListener("rightclick",(event)=>{
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
            div.style.top = "-15px"
            div.style.left = "-10px"
            let popup = new PopupClass(new google.maps.LatLng(Number(latitud), Number(longitud)), div, false);
            popup.setMap(this.mapa)

            div.addEventListener("mouseleave",()=>{popup.remove();div.remove()})
            div.addEventListener("click",()=>{popup.remove();div.remove()})

            div.onclick = ()=>{
                let ubicacion = new google.maps.LatLng(Number(latitud), Number(longitud))
                this.mapa.setCenter(ubicacion)
                geoposicionUsuario= {lat: latitud, lng:longitud}
                actualizar_datos()
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
        //lee el google.searchBox, cambia la ubicacion y actualiza los datos //TODO: cambiar de procedimiento a funcion
        cambiarLugar(){
            let lugar = this.autocompletado_input.getPlaces()[0]
            geoposicionUsuario = {lat:lugar.geometry.location.lat(),lng:lugar.geometry.location.lng()}

            let bounds = new google.maps.LatLngBounds();
            bounds.union(lugar.geometry.viewport);
            this.mapa.fitBounds(bounds);

            actualizar_datos()
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
        addCustomMarker(lat, lng, div, id, eventoObject) {
            let popup = new PopupClass(new google.maps.LatLng(lat, lng), div);
            popup.id = id
            this.estaObteniendoUbicacion? null : popup.setMap(this.mapa);
            eventoObject.popup = popup
            this.marcadores[id] = eventoObject
            div.style.opacity = 0
            setTimeout(()=>{this.actualizarIconoZoom();div.style.opacity = 1},20) //delay para que se actualize en base a zoom
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
        //obtener los popups que esten visibles en la ventana del mapa
        obtenerPopusVisibles() {
            let popupsVisibles = []
            if(this.estaObteniendoUbicacion){return}
            for (let evento of Object.values(this.marcadores)) {
                if (evento.popup.esVisible()) {
                    popupsVisibles.push(evento.popup)
                }
            }
            return popupsVisibles
        }
        //TODO: refactorizar actualizacion mediante arrastrasdo
        actualizarMedianteArrastrado(){
            google.maps.event.addListenerOnce(this.mapa, 'idle', () => {
                setTimeout(actualizar_listado_popus_visibles, 250)
            })
        }
        //coge la geolocalizacion, si falla, lo gestiona
        geolocalizar(){
            let terminar; // se hace esto porque el navigator.geolocation parece que funciona de forma asincrona
            let terminado = new Promise((success)=>terminar=success)

            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    (data)=>{
                        geoposicionUsuario.lat = data.coords.latitude
                        geoposicionUsuario.lng = data.coords.longitude
                        this.mapa.setCenter(geoposicionUsuario)
                        terminar()
                    },
                    ()=>{
                        console.log("geolocalizacion desactivada")
                        terminar()
                    }
                )
            } else {
                alert("geolocalizacion no soportado por el dispositivo")
                terminar()
            }
            terminado.then(actualizar_datos)
        }
    }
}



//se estructura asi porque dentro se utiliza clases que se importan de forma asincrona
cargarPopupClass = () => {
    return class PopupClass extends google.maps.OverlayView {
        position;
        containerDiv;
        constructor(position, element, hacerAnchor = true) {
            super();
            this.position = {lat:position.lat(),lng:position.lng()};
            element.classList.add("popup-bubble");

            // decorador de la burbuja (triangulo de abajo)
            const bubbleAnchor = document.createElement("div");
            hacerAnchor?bubbleAnchor.classList.add("popup-bubble-anchor"):null;
            bubbleAnchor.appendChild(element);
            // contenedor del popup
            this.containerDiv = document.createElement("div");
            this.containerDiv.classList.add("popup-container");
            this.containerDiv.appendChild(bubbleAnchor);
            // el popup bloquea la interaccion con el mapa.
            PopupClass.preventMapHitsAndGesturesFrom(this.containerDiv);


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
        // comprueba si el popup esta dentro de la ventana del mapa
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
        //oculta del mapa
        remove(){
            this.setMap(null)
        }
    }
}



// importacion de las clases de la api
google.maps.importLibrary("maps").then(
    () => {
        AdvancedMarkerViewClass = google.maps.Marker;
        PopupClass = cargarPopupClass()


        google.maps.importLibrary("places").then(()=>{
            let MapaClass = cargarMapaClass()
            MapaGoogleObject = new MapaClass() // isntancia del objeto mapa
            terminadoDeCargar() // resolucion de la promesa de cargado
        })


    }
);

// function showEventDetails(div, datos) {
//     var modal = document.getElementById('modal');
//     var modalContent = document.getElementById('modal-content');
//     var eventoDiv = div;

//     // Copia el contenido del evento al modal
//     modalContent.innerHTML = eventoDiv.innerHTML;

//     // Selecciona el div contenido-datos dentro del modalContent
//     var contenidoDatosDiv = modalContent.querySelector('.contenido-datos');

//     // Agrega la descripción y el botón de unirse al div contenido-datos
//     var descripcion = document.createElement('p');
//     var descripcionTexto = document.createElement('span');
//     descripcion.textContent = 'Descripción: ';
//     // descripcionTexto.textContent = datos['descripcion'];

//     // Establece el estilo de la descripción a negrita y el texto de descripción a cursiva
//     descripcion.style.fontWeight = 'bold';
//     descripcionTexto.style.fontStyle = 'italic';

//     contenidoDatosDiv.appendChild(descripcion);
//     contenidoDatosDiv.appendChild(descripcionTexto);

//     var unirseBtn = document.createElement('button');
//     unirseBtn.textContent = 'Unirse';
//     contenidoDatosDiv.appendChild(unirseBtn);

//     // Muestra el modal
//     modal.style.display = 'block';
// }


// funcion encargada de ocultar el overlay que se abre al clickar un popup
function ocultar(event) {
    event.target.id == "modal" ? event.target.style.display = "none" : null
}

//actualiza el lsitado de eventos visibles en la pestaña de buscar eventos
function actualizar_listado_popus_visibles(){
    let popupsVisibles =MapaGoogleObject.obtenerPopusVisibles()
    popupsVisibles?null:popupsVisibles=[]

    buscarEventoSectionAppObject.vaciarEventosVisibles()
    popupsVisibles.forEach(function(ele){
        buscarEventoSectionAppObject.addEventoVisible(ele.id)
    })


    MapaGoogleObject.actualizarMedianteArrastrado()
}

//lamada a la api con la posicion del mapa, y la distancia para conseguir los eventos cercanos
async function actualizar_datos(){
    await $.get("./api/NearEvents/"+geoposicionUsuario.lat+"/"+geoposicionUsuario.lng+"/"+Number($("#distance").text()),function(data){
        // modifica el var datos con los nuevos datos y calcula la distancia
        //TODO: quitar? reestructurar para que "datos" sea por GoogleMapObject
        // data.forEach(function(ele){
        //     datos[ele.id] = ele
        //     datos[ele.id].distancia = getDistanceFromLatLonInKm(datos[ele.id].lat,datos[ele.id].lng,geoposicionUsuario.lat,geoposicionUsuario.lng)
        // })
        // modifica el var datos con los nuevos datos y crea su objeto fecha
        data.forEach(function(datos){
            let eventoDatos = datos
            eventoDatos.distancia = getDistanceFromLatLonInKm(datos.lat, datos.lng, geoposicionUsuario.lat, geoposicionUsuario.lng)
            eventoDatos.fecha = new Date(datos["fecha"])

            //si ya existia el evento, lo actualiza
            if(Object.keys(MapaGoogleObject.marcadores).includes(String(datos.id))){
                Object.keys(eventoDatos).forEach(function(atributo){
                    MapaGoogleObject.marcadores[eventoDatos.id].evento[atributo] = eventoDatos[atributo]
                })
                return
            }

            div = document.createElement("div")
            fecha = new Date(datos.fecha)


            let eventoApp = createApp({
                data(){
                    return {
                        id:datos.id,
                        fecha:fecha,
                        dato:eventoDatos,
                        popup:null,
                        showEventAppObject:showEventAppObject
                    }
                },
                computed:{
                    datos(){
                        return this.dato
                    },
                    evento(){
                        return this.datos
                    }
                },
                method:{
                    remove(){
                        this.popup.remove()
                    }
                },
                template:`
                <div class="evento" v-on:click="showEventAppObject.showEventDetails(id)">
                    <div class="icono"></div>
                    <div class="contenido">
                        <div class="contenido-imagen">
                            <img :src='"images/uploads/"+evento.imagen' alt="Imagen del evento">
                        </div>
                        <div class="contenido-datos">
                            <h2><i>{{evento.nombre}}</i></h2>
                            <p><b>Fecha:</b> {{fecha.toLocaleDateString("es-ES",{weekday:"long", year:"numeric",month:"long",day:"numeric"})}}</p>
                            <p><b>Hora:</b> {{fecha.getHours()}} : {{String(fecha.getMinutes()).padStart("2","0")}}</p>
                            <p><b>Asistentes</b>: {{evento.asistentes}} / {{evento.limite_asistentes}}</p>
                        </div>
                    </div>
                </div>`
            })
            let eventoObject = eventoApp.mount(div)
            MapaGoogleObject.addCustomMarker(datos.lat, datos.lng, div.children[0], datos.id, eventoObject)

        })

        //eliminar eventos que ya no existen en el mapa
        let indiceDatosActivo = data.map((dato)=>dato.id)
        Object.keys(MapaGoogleObject.marcadores).forEach(function(indiceMarcador){
            if(!indiceDatosActivo.includes(Number(indiceMarcador))){
                MapaGoogleObject.marcadores[indiceMarcador].popup.remove()
                buscarEventoSectionAppObject.vaciarEventosVisibles()
                delete(MapaGoogleObject.marcadores[indiceMarcador])
                // delete(datos[index])
            }
        })

        setTimeout(actualizar_listado_popus_visibles,150)
    })
}

// envia los datos para la creacion del evento
async function enviar_datos_crear_evento(){
    let formData = new FormData($("#formulario_crear")[0])
    $.ajax({
        type:'POST',
        url: "/crearEvento",
        data:formData,
        cache:false,
        contentType: false,
        processData: false,
        success:function(data){
            console.log("success");
            console.log(data);
            setTimeout(actualizar_datos,250)
        },
        error: function(data){
            console.log("error");
            console.log(data);
        }
    });
    document.getElementById('latitud').value = null;
    document.getElementById('longitud').value = null;
    MapaGoogleObject.eliminarEventosObtenerUbicacion(true)
}

