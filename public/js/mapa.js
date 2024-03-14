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
var datos={}; // datos en crudo que se recibe del servidor

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
    return class MapaGoogle {
        marcadores = []

        constructor() {
            this.mapa = new google.maps.Map(document.getElementById("map"), {
                center: geoposicionUsuario.lat? geoposicionUsuario : { lat: 28.9504656, lng: -13.589889 },
                zoom: 15,
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
            this.eventoActivo=false

            // Wait for the map to be fully loaded before accessing its properties

            this.buttonObtenerUbicacion.addEventListener("click", this.obtenerUbicacion.bind(this));
        }
        obtenerUbicacion(){
            if(this.eventoActivo){return}
            this.eventoActivo=true
            // Remove all previous markers
            for (let i = 0; i < this.marcadores.length; i++) {
                this.marcadores[i].setMap(null);
            }

            // Create a marker at the center of the map
            if(!this.marker){
                this.marker = new AdvancedMarkerViewClass({
                    position: this.mapa.getCenter(),
                    map: this.mapa,
                    id:"marcador_de_ubicacion",
                    icon: 'https://maps.google.com/mapfiles/ms/icons/red-dot.png' // Use a custom icon
                });
            }else{
                this.marker.setMap(this.mapa)
            }

            // Update the marker position when the mouse moves
            this.mouseMoveListener = this.mapa.addListener('mousemove', function (event) {
                this.marker.setPosition(event.latLng);
            }.bind(this));

            // Place the marker and remove the listeners when the map is clicked
            // this.clickListener = [this.mapa,this.marker].forEach(element => {
            this.clickListeners = [];
            [this.mapa,this.marker].forEach((element) => {

                let temp = element.addListener('click', function (event) {
                    if(!this.eventoActivo ){return}
                    this.placeMarker(event.latLng);
                    this.eliminarEventosObtenerUbicacion()
                }.bind(this));
                this.clickListeners.push(temp)
            })
        }
        eliminarEventosObtenerUbicacion(forzozo=false){
            if(forzozo && this.marker){this.marker.setMap(null)}
            if(!this.eventoActivo){return}
            this.eventoActivo = false
            google.maps.event.removeListener(this.mouseMoveListener)
            this.clickListeners.forEach(function(ele){
                google.maps.event.removeListener(ele)
            })
            for (let i = 0; i < this.marcadores.length; i++) {
                this.marcadores[i].setMap(this.mapa);
            }
        }
        cambiarLugar(){
            let lugar = this.autocompletado_input.getPlaces()[0]
            geoposicionUsuario = {lat:lugar.geometry.location.lat(),lng:lugar.geometry.location.lng()}

            let bounds = new google.maps.LatLngBounds();
            bounds.union(lugar.geometry.viewport);
            this.mapa.fitBounds(bounds);

            actualizar_datos()
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
            const marker = new AdvancedMarkerViewClass({
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
        removeMarkers(){
            this.marcadores.forEach(function(ele){
                ele.setMap(null)
            })
            this.marcadores = []
        }

        addCustomMarker(lat, lng, div,id) {
            let popup = new PopupClass(new google.maps.LatLng(lat, lng), div);
            popup.id = id
            popup.setMap(this.mapa);
            this.marcadores.push(popup)
            div.style.opacity = 0
            setTimeout(()=>{this.actualizarIconoZoom();div.style.opacity = 1},20)
            return popup
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
            if(this.eventoActivo){return}
            for (let popup of this.marcadores) {
                if (popup.esVisible()) {
                    popupsVisibles.push(popup)
                }
            }
            return popupsVisibles
        }
        actualizarMedianteArrastrado(){
            google.maps.event.addListenerOnce(this.mapa, 'idle', () => {
                setTimeout(actualizar_listado_popus_visibles, 250)
            })
        }
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
                        alert("geolocalizacion desactivada")
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




cargarPopupClass = () => {
    return class PopupClass extends google.maps.OverlayView {
        position;
        containerDiv;
        constructor(position, element) {
            super();
            this.position = {lat:position.lat(),lng:position.lng()};
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
        remove(){
            this.setMap(null)
            let indice = MapaGoogleObject.marcadores.indexOf(this)
            indice!=-1?MapaGoogleObject.marcadores.splice(indice,1):null
        }
    }
}




google.maps.importLibrary("maps").then(
    () => {
        AdvancedMarkerViewClass = google.maps.Marker;
        PopupClass = cargarPopupClass()


        google.maps.importLibrary("places").then(()=>{
            let MapaClass = cargarMapaClass()
            MapaGoogleObject = new MapaClass()
            terminadoDeCargar()
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



function ocultar(event) {
    event.target.id == "modal" ? event.target.style.display = "none" : null
}

function actualizar_listado_popus_visibles(){
    let popupsVisibles =MapaGoogleObject.obtenerPopusVisibles()
    popupsVisibles?null:popupsVisibles=[]
    buscarEventoSectionAppObject.vaciarEventosVisibles()
    popupsVisibles.forEach(function(ele){
        buscarEventoSectionAppObject.addEventoVisible(ele.id)
    })


    MapaGoogleObject.actualizarMedianteArrastrado()
}
var eventosObject={}
async function actualizar_datos(){
    await $.get("./api/NearEvents/"+geoposicionUsuario.lat+"/"+geoposicionUsuario.lng+"/"+Number($("#distance").text()),function(data){
        data.forEach(function(ele){
            datos[ele.id] = ele
            datos[ele.id].distancia = getDistanceFromLatLonInKm(datos[ele.id].lat,datos[ele.id].lng,geoposicionUsuario.lat,geoposicionUsuario.lng)
        })
        data.forEach(function(ele){
            if(ele.id in eventosObject){
                Object.keys(ele).forEach(function(key){
                    if(key == "fecha"){
                        eventosObject[ele.id].evento[key] = new Date(ele[key])
                    }else{
                        eventosObject[ele.id].evento[key] = ele[key]
                    }
                })
                return
            }
            div = document.createElement("div")
            fecha = new Date(ele.fecha)
            $("#trash")[0].appendChild(div)


            let app = createApp({
                data(){
                    return {
                        id:ele.id,
                        fecha:fecha,
                        dato:datos,
                        popup:null,
                        showEventAppObject:showEventAppObject
                    }
                },
                computed:{
                    datos(){
                        return this.dato
                    },
                    evento(){
                        return this.datos[this.id]
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
            let evento = app.mount(div)
            eventosObject[ele.id] = evento
            // function add(ele,div){
                evento.popup = MapaGoogleObject.addCustomMarker(ele.lat,ele.lng,div.children[0],ele.id)
            // }
            // add(ele,div)

        })

        let datos_act = data.map((dato)=>dato.id)
        Object.keys(datos).forEach(function(index){
            if(!datos_act.includes(Number(index))){ //TODO: hacer que marcadores sea diccionario con id como key
                let indice = MapaGoogleObject.marcadores.map(ele=>ele.id).indexOf(eventosObject[index].popup.id)
                if (indice ==-1){return}
                MapaGoogleObject.marcadores.splice(indice,1)
                delete(datos[index])
                eventosObject[index].popup.remove()
                delete(eventosObject[index])
            }
        })

        setTimeout(actualizar_listado_popus_visibles,150)
    })
}


async function enviar_datos_evento(){
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

