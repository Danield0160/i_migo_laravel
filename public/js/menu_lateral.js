// const { computed } = require("vue");

// const { data } = require("autoprefixer");

// ---------Responsive-navbar-active-animation-----------
function test(){
	var tabsNewAnim = $('#navbarSupportedContent');
	var selectorNewAnim = $('#navbarSupportedContent').find('li').length;
	var activeItemNewAnim = tabsNewAnim.find('.active');
	var activeWidthNewAnimHeight = activeItemNewAnim.innerHeight();
	var activeWidthNewAnimWidth = activeItemNewAnim.innerWidth();
	var itemPosNewAnimTop = activeItemNewAnim.position();
	var itemPosNewAnimLeft = activeItemNewAnim.position();
	$(".hori-selector").css({
		"top":itemPosNewAnimTop.top + "px",
		"left":itemPosNewAnimLeft.left + "px",
		"height": activeWidthNewAnimHeight + "px",
		"width": activeWidthNewAnimWidth + "px"
	});
	$("#navbarSupportedContent").on("click","li",function(e){
		$('#navbarSupportedContent ul li').removeClass("active");
		$(this).addClass('active');
		var activeWidthNewAnimHeight = $(this).innerHeight();
		var activeWidthNewAnimWidth = $(this).innerWidth();
		var itemPosNewAnimTop = $(this).position();
		var itemPosNewAnimLeft = $(this).position();
		$(".hori-selector").css({
			"top":itemPosNewAnimTop.top + "px",
			"left":itemPosNewAnimLeft.left + "px",
			"height": activeWidthNewAnimHeight + "px",
			"width": activeWidthNewAnimWidth + "px"
		});
	});
}
$(document).ready(function(){
	setTimeout(function(){ test(); });
});
$(window).on('resize', function(){
	setTimeout(function(){ test(); }, 500);
});
$(".navbar-toggler").click(function(){
	$(".navbar-collapse").slideToggle(300);
	setTimeout(function(){ test(); });
});



// --------------add active class-on another-page move----------
jQuery(document).ready(function($){
	// Get current path and find target link
	var path = window.location.pathname.split("/").pop();

	// Account for home page with empty path
	if ( path == '' ) {
		path = 'index.html';
	}

	var target = $('#navbarSupportedContent ul li a[href="'+path+'"]');
	// Add active class to target link
	target.parent().addClass('active');
});







//TAGS, las tags existentes
$.get("./api/AllTags",function(raw_data){
    data ={}
    raw_data.forEach(dato => {
        data[dato.id] = {category_name:dato.category_name,id:dato.id}
    });
    TAGS = data
})

//USER_IMAGES, las imagenes que son del usuario
var resolver_cargado_imagenes;
var promesa_imagenes = new Promise((res)=>resolver_cargado_imagenes=res)
function cargar_imagenes(appObject=null){

    $.get("./api/MyPhotos",function(raw_data){
        data ={}
        raw_data.forEach(dato => {
            data[dato.id] = {imagePath:dato.imagePath, id:dato.id}
        });
        USER_IMAGES = data
        if(resolver_cargado_imagenes){
            resolver_cargado_imagenes()
        }

        if(appObject){
            appObject.datos=USER_IMAGES
        }
    })
}
cargar_imagenes()



// componente del selector de imagenes
async function crearChooseImageSectionApp(perfilOEvento, montaje){
    await promesa_imagenes
    chooseImageSection = createApp({
        data(){
            return {
                activo:false,
                datos:USER_IMAGES,
                modo: perfilOEvento,
                preview:null
            };
        },
        template:SELECTOR_IMAGENES_TEMPLATE,
        methods:{
            activar(){
                this.activo = true

            },
            desactivar(forzar = false){
                this.activo = false
                if(forzar){
                    chooseImageSection.unmount()
                }
            },
            imagen(id){
                return "images/"+USER_IMAGES[id].imagePath
            },
            iniciar_escucha(){
                setTimeout(()=>
                    document.getElementById('choose_imagen_nueva').addEventListener('change', (e)=> {
                        if (e.target.files[0]) {
                            this.subir_imagen()
                        }})
                ,50)
            },
            subir_imagen(){
                let formData = new FormData($("#formulario_subir_foto")[0])
                console.log("envio")
                $.ajax({
                    type:'POST',
                    url: "/api/uploadImage",
                    data:formData,
                    cache:false,
                    contentType: false,
                    processData: false,
                    success:function(data){
                        // console.log("success");
                        cargar_imagenes(chooseImageSectionObject)
                    },
                    error: function(data){
                        console.log("error");
                    }
                });
                this.desactivar()
            },
            elegir_imagen(id){
                if(this.modo == "perfil"){
                    $.ajax({
                        url: "/api/MyProfile/ChangePhoto/"+id, //TODO cambiar a put
                        type: 'GET',
                        success: function(data) {
                            profileSectionAppObject.cargar_perfil()
                        }
                    });
                    this.desactivar(true)


                }else if(this.modo == "evento"){
                    document.querySelector("#imagen_id").value = id
                    this.preview = "images/"+id
                    this.desactivar()
                }
            },
            remove_image(event){
                object = this
                let formData = new FormData(event.target.parentElement);
                $.ajax({
                    url: "/api/deleteImage",
                    data:formData,
                    type: 'POST',
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        cargar_imagenes(chooseImageSectionObject)
                        object.desactivar()
                        if(formData.get("id") == profileSectionAppObject.data.profile_photo_id){
                            chooseImageSection.unmount()
                            profileSectionAppObject.data.profile_photo_id = 1
                        }
                    },
                    error(data){
                        console.log(data)
                    }
                });
            }
        },computed:{
            imagenes(){
                return this.datos
            }
        }
    })
    chooseImageSectionObject =chooseImageSection.mount("#"+montaje)
    cargar_imagenes(chooseImageSectionObject)

}


// componente del perfil
var profileSectionAppObject;
async function crearProfileSectionApp(template){
    ProfileSectionApp = createApp({
        data(){
            $("#profile_button").on("click",function(){profileSectionAppObject.activar()})
            return {
                activo:false,
                data:null
            };
        },
        template:template,
        methods:{
            activar(){
                desactivarGlobal()
                this.activo = true
            },
            desactivar(){
                this.activo = false
            },
            crearChooseImageSectionApp(perfilOEvento,disparador,montaje){
                crearChooseImageSectionApp(perfilOEvento,disparador,montaje)
            },
            imagen(id){
                if(USER_IMAGES[id]){
                    return "images/uploads/"+USER_IMAGES[id].imagePath
                }
                return "images/1"
            },
            cargar_perfil(){
                cargar_perfil()
            }
        },computed:{
            datos(){
                return this.data
            },
            cargado(){
                return this.data != null
            }
        }
    })
    profileSectionAppObject = ProfileSectionApp.mount("#perfilSection")

    // PROFILE_DATA;
    function cargar_perfil(){
        $.get("./api/MyProfile",function(data){
            profileSectionAppObject.data = data[0]
        })
    }
    cargar_perfil()
}


// componente del creador de eventos
var crearEventoSectionAppObject;
async function crearEventoSectionApp(template){
    await AllLoaded;
    EventoSectionApp = createApp({
        data(){
            $("#crear_evento_button").on("click",function(){crearEventoSectionAppObject.activar()})
            // crearChooseImageSectionApp("evento","choose_image_event")
            ocultarBoton =async ()=>{await  AllLoaded;
                MapaGoogleObject.buttonObtenerUbicacion.style.opacity = "0";
                MapaGoogleObject.buttonObtenerUbicacion.style.pointerEvents = "none";
            }
            ocultarBoton()
            return {
                activo:false,
                eventos_agregados:{}
            };
        },
        template:template,
        methods:{
            activar(){
                if(this.activo){
                    return
                }
                desactivarGlobal()
                this.activo = true
                MapaGoogleObject.buttonObtenerUbicacion.style.opacity = "1"
                MapaGoogleObject.buttonObtenerUbicacion.style.pointerEvents = ""; //TODO revisar esto
                // crearChooseImageSectionApp("evento","choose_image_event")

            },
            desactivar(){
                MapaGoogleObject.eliminarEventosObtenerUbicacion(true)
                MapaGoogleObject.buttonObtenerUbicacion.style.opacity = "0"
                MapaGoogleObject.buttonObtenerUbicacion.style.pointerEvents = "none";
                this.activo = false
                Object.values(this.eventos_agregados).forEach((evento)=>{evento.popup.remove()})
            },
            crearChooseImageSectionApp(perfilOEvento,disparador,montaje){
                crearChooseImageSectionApp(perfilOEvento,disparador,montaje)
            },
            enviar_datos_crear_evento(){
                if(document.getElementById('latitud').value == ''){
                    return
                }
                object = this
                let formData = new FormData($("#formulario_crear")[0])
                console.log(formData.get("latitud"))
                console.log(document.getElementById('latitud').value)
                var boxes = document.getElementsByClassName('checkbox_create_event_tag');
                var checked = [];
                for (var i = 0; boxes[i]; ++i) {
                    if (boxes[i].checked) {
                        checked.push(boxes[i].value);
                        boxes[i].checked = false
                    }
                }
                formData.append("tags",checked)

                $.ajax({
                    type:'POST',
                    url: "/api/CreateEvent",
                    data:formData,
                    cache:false,
                    contentType: false,
                    processData: false,
                    success:function(data){
                        eventoObject = createPopup(data)
                        eventoObject.datos.date = new Date(data.date)
                        eventoObject.popup.append()
                        chooseImageSectionObject.preview = null
                        $("#formulario_crear")[0].reset()
                        object.eventos_agregados[eventoObject.id] = eventoObject
                        Toastify({
                            text: "Evento Creado",
                            duration: 3000,
                            style: {
                                background: "linear-gradient(to right, #00f555, #00f999)",
                            }
                            }).showToast();
                    },
                    error: function(data){
                        Toastify({
                            text: data.responseJSON.error,
                            duration: 3000,
                            style: {
                                background: "linear-gradient(to right, #ff5555, #ff7777)",
                            }
                            }).showToast();
                    }
                });

                MapaGoogleObject.eliminarEventosObtenerUbicacion(true)
            },
            seleccionar(event){
                if(event.target.tagName != "LABEL"){
                    return
                }
                event.target.parentElement.classList.toggle("activo")
            }
        },computed:{
            tags(){
                return TAGS;
            }
        }
    })
    crearEventoSectionAppObject = EventoSectionApp.mount("#crearEventoSection")
}

// componente del buscador de eventos
var buscarEventoSectionAppObject;
async function buscarEventoSectionApp(template){
    await AllLoaded;
    EventoSectionApp = createApp({
        data(){
            $("#buscar_eventos_button")[0].onclick =function(){buscarEventoSectionAppObject.activar()}
            google.maps.event.addListener(MapaGoogleObject.mapa, 'idle', () => {
                setTimeout(()=>this.actualizar= !this.actualizar, 250);
            })
            return {
                activo:true,
                input:"",
                ultimo_evento_mostrado:null,
                ultimo_evento_mostrado_div: null,
                eventos_cercanos:{},
                actualizar:true
            };
        },
        template:template,
        methods:{
            activar(){
                if(this.activo){
                    return
                }
                desactivarGlobal()
                this.activo = true
                Object.values(this.eventos_cercanos).forEach((evento)=>evento.popup.append())
                
            },
            desactivar(){
                this.activo = false
                Object.values(this.eventos_cercanos).forEach((evento)=>evento.popup.remove())
            },
            joinEvent(event){
                formData = new FormData(event.target.parentElement)
                $.ajax({
                    type:'POST',
                    url: "/api/JoinEvent",
                    data:formData,
                    cache:false,
                    contentType: false,
                    processData: false,
                    success:function(data){
                        // console.log("success");
                        actualizar_datos();
                        misEventoSectionAppObject.cargar_mis_eventos_unidos()
                    },
                    error: function(data){
                        console.log("error");
                    }
                });
            },
            salirse_de_evento(event){
                formData = new FormData(event.target.parentElement)
                $.ajax({
                    type:'POST',
                    url: "/api/LeaveEvent",
                    data:formData,
                    cache:false,
                    contentType: false,
                    processData: false,
                    success:function(data){
                        // console.log("success");
                        actualizar_datos()
                        misEventoSectionAppObject.cargar_mis_eventos_unidos();
                    },
                    error: function(data){
                        console.log("error");
                    }
                });
            },
            me_puedo_unir(id){
                if(misEventoSectionAppObject.eventos_unidos == null || misEventoSectionAppObject.eventos_creados == null){
                    return false
                }
                if(id in misEventoSectionAppObject.eventos_unidos){
                    return false
                }
                if(id in misEventoSectionAppObject.eventos_creados){
                    return false
                }
                if(id in crearEventoSectionAppObject.eventos_agregados){
                    return false
                }
                return true
            },
            me_puedo_salir(id){
                if(misEventoSectionAppObject.eventos_unidos == null){
                    return false
                }
                if(id in misEventoSectionAppObject.eventos_unidos){
                    return true
                }
                return false
            },
            es_propietario(id){
                if(misEventoSectionAppObject.eventos_creados == null){
                    return false
                }
                if (id in misEventoSectionAppObject.eventos_creados){
                    return true
                }
                if(id in crearEventoSectionAppObject.eventos_agregados){
                    return true
                }
                return false
            },
            actualizar_datos(){
                actualizar_datos()
            },
            ubicar(event,evento,eventos){
                if(event.target.tagName == "BUTTON"){
                    return
                }
                evento.popup.ubicar(event,eventos,this.ultimo_evento_mostrado );

                if(this.ultimo_evento_mostrado==evento.id){
                    this.ultimo_evento_mostrado=null
                }else{
                    this.ultimo_evento_mostrado= evento.id
                }
            },
        },
        computed:{

            TAGS(){
                return TAGS
            },
            eventosVisibles(){
                this.actualizar;
                let eventosVisibles = []
                Object.values(this.eventos_cercanos).forEach((x)=>{if(x.popup.esVisible()){eventosVisibles.push(x)}})

                let eventos_filtrado=[]
                eventosVisibles.forEach(evento => {
                    if (lista_contiene_lista(Object.values(evento.datos).map((x)=>String(x).toLowerCase()),this.input.toLowerCase().split(" "))){
                        eventos_filtrado.push(evento)
                    }
                });

                return eventos_filtrado.sort((a,b)=>{
                    let dist_a = a.datos.distancia;
                    let dist_b = b.datos.distancia;
                    if (dist_a<dist_b){return -1}
                    if (dist_a>dist_b){return 1}
                    else{return 0}
                })
            },
            eventosCercanos(){
                return Object.values(this.eventos_cercanos)
            }
        }

    })
    buscarEventoSectionAppObject = EventoSectionApp.mount("#buscarEventoSection")

    //actualiza los datos del buscador de eventos
    async function actualizar_datos(){
        await $.get("./api/NearEvents/"+geoposicionUsuario.lat+"/"+geoposicionUsuario.lng+"/"+Number($("#distance").val().replace("km","")),function(data){
            data.forEach(function(eventoDatos){
                eventoDatos.distancia = getDistanceFromLatLonInKm(eventoDatos.lat, eventoDatos.lng, geoposicionUsuario.lat, geoposicionUsuario.lng)
                eventoDatos.date = new Date(eventoDatos["date"])
                eventoDatos.tags = eventoDatos.tags? eventoDatos.tags.split(",").map((x)=>TAGS[x].category_name).join() : null

                //si ya existia el evento, lo actualiza
                if(Object.keys(buscarEventoSectionAppObject.eventos_cercanos).includes(String(eventoDatos.id))){
                    Object.keys(eventoDatos).forEach(function(atributo){
                        buscarEventoSectionAppObject.eventos_cercanos[eventoDatos.id].datos[atributo] = eventoDatos[atributo]
                    })
                    return
                }

                //si no existe, lo crea
                eventoObject = createPopup(eventoDatos)
                buscarEventoSectionAppObject.eventos_cercanos[eventoDatos.id] = eventoObject
                if(buscarEventoSectionAppObject.activo){
                    eventoObject.popup.append()
                }
            })

            //eliminar eventos que ya no existen en el mapa (osea, si se elimino el evento o esta lejos de tu distancia marcada)
            let indicesEventosCercanos = data.map((dato)=>dato.id)
            Object.keys(buscarEventoSectionAppObject.eventos_cercanos).forEach(function(indiceEventoGuardado){
                if(!indicesEventosCercanos.includes(Number(indiceEventoGuardado))){
                    buscarEventoSectionAppObject.eventos_cercanos[indiceEventoGuardado].popup.remove()
                    delete(buscarEventoSectionAppObject.eventos_cercanos[indiceEventoGuardado])
                }
            })
        })

    }
    actualizar_datos()
    setInterval(()=>{if(buscarEventoSectionAppObject.activo){actualizar_datos()}},3000)

}




// componente de mis eventos
var misEventoSectionAppObject;
function misEventoSectionApp(template){
    MisEventoSectionApp = createApp({
        data(){
            $("#mis_eventos_button")[0].onclick =function(){misEventoSectionAppObject.activar()}
            return {
                activo:false,
                modo:"Eventos unidos",
                eventos_unidos:{},
                eventos_creados:{},
                geoposicionUsuario:geoposicionUsuario,
                ultimo_evento_mostrado:null
            };
        },
        template:template,
        methods:{
            activar(){
                if(this.activo){
                    return
                }
                desactivarGlobal()
                this.activo = true
                this.modo="Eventos unidos"
                this.eventos_unidos? Object.values(this.eventos_unidos).forEach((evento)=>evento.popup.append()) : null
                this.eventos_creados? Object.values(this.eventos_creados).forEach((evento)=>evento.popup.remove()) : null
            },
            desactivar(){
                this.activo = false
                this.eventos_unidos? Object.values(this.eventos_unidos).forEach((evento)=>evento.popup.remove()) : null
                this.eventos_creados? Object.values(this.eventos_creados).forEach((evento)=>evento.popup.remove()) : null
                this.ultimo_evento_mostrado = null

            },
            salirse_de_evento(event){
                formData = new FormData(event.target.parentElement)
                $.ajax({
                    type:'POST',
                    url: "/api/LeaveEvent",
                    data:formData,
                    cache:false,
                    contentType: false,
                    processData: false,
                    success:function(data){
                        // console.log("success");
                        cargar_mis_eventos_unidos();
                    },
                    error: function(data){
                        console.log("error");
                    }
                });
            },
            eliminar_evento(){
                formData = new FormData(event.target.parentElement)
                $.ajax({
                    type:'POST',
                    url: "/api/DeleteEvent",
                    data:formData,
                    cache:false,
                    contentType: false,
                    processData: false,
                    success:function(data){
                        // console.log("success");
                        cargar_mis_eventos_creados();
                    },
                    error: function(data){
                        console.log("error");
                    }
                });
            },
            distancia(lat,lng){
                return getDistanceFromLatLonInKm(lat,lng,this.geoposicionUsuario.lat,this.geoposicionUsuario.lng)

            },
            changeMode(modo){
                if(this.modo != modo){
                    this.ultimo_evento_mostrado = null
                }
                this.modo = modo
                let eventos_a_poner = modo=="Eventos unidos"? this.eventos_unidos : this.eventos_creados;
                let eventos_a_quitar = modo=="Eventos unidos"? this.eventos_creados : this.eventos_unidos;

                eventos_a_poner? Object.values(eventos_a_poner).forEach((evento)=>evento.popup.append()) : null
                eventos_a_quitar? Object.values(eventos_a_quitar).forEach((evento)=>evento.popup.remove()) : null

            },
            ubicar(event,evento,eventos){
                if(event.target.tagName == "BUTTON" || event.target.classList.contains("boton_participantes")){
                    return
                }
                evento.popup.ubicar(event,eventos,this.ultimo_evento_mostrado );

                if(this.ultimo_evento_mostrado==evento.id){
                    this.ultimo_evento_mostrado=null
                }else{
                    this.ultimo_evento_mostrado= evento.id
                }
            },
            cargar_mis_eventos_unidos(){
                cargar_mis_eventos_unidos()
            },
            cargar_mis_eventos_creados(){
                cargar_mis_eventos_creados()
            },
            mostrarParticipantes(evento_id){
                $.ajax({
                    type:'GET',
                    url: "/api/JoinedUsers/"+evento_id,
                    cache:false,
                    contentType: false,
                    processData: false,
                    success:function(data){
                        // console.log("success");
                        if(data.length != 0){
                            showEventAppObject.showEventDetails(data)
                        }
                    },
                    error: function(data){
                        console.log("error");
                    }
                });
            }
        },computed:{
            eventos_seleccionados(){
                if (this.modo == "Eventos unidos"){
                    return Object.values(this.eventos_unidos).sort((a,b)=>{
                        let dist_a = a.datos.distancia;
                        let dist_b = b.datos.distancia;
                        if (dist_a<dist_b){return -1}
                        if (dist_a>dist_b){return 1}
                        else{return 0}
                    })
                }else{
                    return Object.values(this.eventos_creados).sort((a,b)=>{
                        let dist_a = a.datos.distancia;
                        let dist_b = b.datos.distancia;
                        if (dist_a<dist_b){return -1}
                        if (dist_a>dist_b){return 1}
                        else{return 0}
                    })
                }
            },
            TAGS(){
                return TAGS
            }
        }
    })

    misEventoSectionAppObject = MisEventoSectionApp.mount("#misEventoSection")


    // Mis eventos unidos;
    function cargar_mis_eventos_unidos(){
        $.get("./api/MyJoinedEvents",function(eventos){
            data = {}
            eventos.forEach((evento)=>{
                if(!(evento.id in misEventoSectionAppObject.eventos_unidos)){
                    eventoObject = createPopup(evento)
                }else{
                    eventoObject = misEventoSectionAppObject.eventos_unidos[evento.id]
                }
                Object.keys(evento).forEach(function(atributo){
                    eventoObject.datos[atributo] = evento[atributo]
                })
                eventoObject.datos.distancia = getDistanceFromLatLonInKm(geoposicionUsuario.lat,geoposicionUsuario.lng,evento.lat,evento.lng)
                eventoObject.datos.date = new Date(evento.date)
                if(misEventoSectionAppObject.modo=="Eventos unidos" && misEventoSectionAppObject.activo){
                    eventoObject.popup.append()
                }
                data[evento.id] = eventoObject
            })
            let indicesEventosUnidosActuales = eventos.map((dato)=>dato.id)
            Object.keys(misEventoSectionAppObject.eventos_unidos).forEach(function(indiceEventoUnidoAntiguo){
                if(!indicesEventosUnidosActuales.includes(Number(indiceEventoUnidoAntiguo))){
                    misEventoSectionAppObject.eventos_unidos[indiceEventoUnidoAntiguo].popup.remove()
                    delete(misEventoSectionAppObject.eventos_unidos[indiceEventoUnidoAntiguo])
                }
            })
            misEventoSectionAppObject.eventos_unidos = data


        })
    }
    cargar_mis_eventos_unidos()
    setInterval(()=>{if(misEventoSectionAppObject.activo){cargar_mis_eventos_unidos()}},3000)


    // Mis eventos creados;
    function cargar_mis_eventos_creados(){
        $.get("./api/MyCreatedEvents",function(eventos){
            data = {}
            eventos.forEach((evento)=>{
                if(!(evento.id in misEventoSectionAppObject.eventos_creados)){
                    eventoObject = createPopup(evento)
                }else{
                    eventoObject = misEventoSectionAppObject.eventos_creados[evento.id]
                }
                Object.keys(evento).forEach(function(atributo){
                    eventoObject.datos[atributo] = evento[atributo]
                })
                eventoObject.datos.distancia = getDistanceFromLatLonInKm(geoposicionUsuario.lat,geoposicionUsuario.lng,evento.lat,evento.lng)
                eventoObject.datos.date = new Date(evento.date)
                if(misEventoSectionAppObject.modo=="Eventos creados" && misEventoSectionAppObject.activo){
                    eventoObject.popup.append()
                }
                data[evento.id] = eventoObject
            })
            let indicesEventosCreadosActuales = eventos.map((dato)=>dato.id)
            Object.keys(misEventoSectionAppObject.eventos_creados).forEach(function(indiceEventoCreadoAntiguo){
                if(!indicesEventosCreadosActuales.includes(Number(indiceEventoCreadoAntiguo))){
                    misEventoSectionAppObject.eventos_creados[indiceEventoCreadoAntiguo].popup.remove()
                    delete(misEventoSectionAppObject.eventos_creados[indiceEventoCreadoAntiguo])
                }
            })

            misEventoSectionAppObject.eventos_creados = data


        })
    }
    cargar_mis_eventos_creados()
    setInterval(()=>{if(misEventoSectionAppObject.activo){cargar_mis_eventos_creados()}},3000)
}


// modal para mostrar los usuarios unidos a un evento
var showEventAppObject;
showEventApp = createApp({
    data(){
        return{
            modal:$("#modal")[0],
            data:null,
        }
    },
    methods:{
        showEventDetails(datos){
            this.modal.style.display = "block"
            this.data = datos
        }
    },
    computed:{
        datos(){
            if(this.data == null){return {}}
            return this.data
        }
    },template:
    `<h1>Participantes</h1>
    <div>
        <div v-for="participante in datos" class="participante">
            <h3>{{participante.name}}</h3>
            <div>
                <img :src="'/images/' + participante.profile_photo_id ">
            </div>
        </div>
    </div>

    `
})


// desactiva todos los componentes, necesario para cambiar de un componente a otro
function desactivarGlobal(){
    crearEventoSectionAppObject.desactivar()
    buscarEventoSectionAppObject.desactivar()
    profileSectionAppObject.desactivar()
    misEventoSectionAppObject.desactivar()
}

//calcular la distancia entre dos puntos, entre el evento y el usuario
function getDistanceFromLatLonInKm(lat1, lon1, lat2, lon2) {
    var R = 6371; // Radius of the earth in km
    var dLat = deg2rad(lat2-lat1);  // deg2rad below
    var dLon = deg2rad(lon2-lon1);
    var a =
      Math.sin(dLat/2) * Math.sin(dLat/2) +
      Math.cos(deg2rad(lat1)) * Math.cos(deg2rad(lat2)) *
      Math.sin(dLon/2) * Math.sin(dLon/2);
    var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
    var d = R * c; // Distance in km
    return d;
}

function deg2rad(deg) {
    return deg * (Math.PI/180)
}

// funcion auxiliar para el filtrado de buscar evento
function lista_contiene_lista(lista1, lista2) {
    for (let palabra of lista2) {
        let encontrada = false;
        for (let item of lista1) {
            if (item.includes(palabra)) {
                encontrada = true;
                break;
            }
        }
        if (!encontrada) {
            return false;
        }
    }
    return true;
}


//compatibilizacion del modo reducido, tanto para dispositivos moviles como desktop
(async()=>{
    await AllLoaded;
    lateral = document.getElementById("lateral-izq")
    drag_pad = document.getElementById("drag_pad")

    drag_pad.addEventListener("mousedown",iniciar_drag)
    drag_pad.addEventListener("pointerdown",iniciar_drag)

    document.addEventListener("mouseup",parar_drag)
    document.addEventListener("pointerup",parar_drag)
    ajuste_inicial()

})()

function iniciar_drag(){
    document.body.addEventListener("mousemove",drag)
    document.body.addEventListener("pointermove",drag)
}
function parar_drag(){
    document.body.removeEventListener("mousemove",drag)
    document.body.removeEventListener("pointermove",drag)
}
function drag(event){
    vh = event.clientY * 100 / window.outerHeight

    if(vh > 87 || vh<0){
        return
    }
    lateral.style.top = vh + "svh"
}

//mueve los elementos de la ui para si es un dispositivo movil
function ajuste_inicial(){
    if(navigator.userAgentData.mobile){
        setTimeout(()=>document.body.querySelector(".gmnoprint").style.marginTop = "10vh",850)
        document.body.querySelector("#buscador_container").style.marginTop = "10vh" //se baja porque la barra de busqueda de los mobiles lo tapa, hacer pruebas
    }
    if(window.innerWidth < 991){
        lateral.style.top = 50 + "vh"
    }

    window.addEventListener('resize', function(event) {
        if(event.target.innerWidth > 991){
            lateral.style.top = 0 + "vh"
        }else{
            lateral.style.top = 50 + "vh"
        }
    }, true);
}