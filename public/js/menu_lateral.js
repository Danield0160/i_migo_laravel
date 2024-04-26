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




// Add active class on another page linked
// ==========================================
// $(window).on('load',function () {
//     var current = location.pathname;
//     console.log(current);
//     $('#navbarSupportedContent ul li a').each(function(){
//         var $this = $(this);
//         // if the current path is like this link, make it active
//         if($this.attr('href').indexOf(current) !== -1){
//             $this.parent().addClass('active');
//             $this.parents('.menu-submenu').addClass('show-dropdown');
//             $this.parents('.menu-submenu').parent().addClass('active');
//         }else{
//             $this.parent().removeClass('active');
//         }
//     })
// });





//TAGS, las tags existentes
$.get("./api/AllTags",function(raw_data){
    data ={}
    raw_data.forEach(dato => {
        data[dato.id] = {category_name:dato.category_name,id:dato.id}
    });
    TAGS = data
})

//USER_IMAGES, las iamgenes que son del usuario
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
                return "images/uploads/"+USER_IMAGES[id].imagePath
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
                eventos_agregados:[]
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
                this.eventos_agregados.forEach((evento)=>{evento.popup.remove();delete(evento)})
            },
            crearChooseImageSectionApp(perfilOEvento,disparador,montaje){
                crearChooseImageSectionApp(perfilOEvento,disparador,montaje)
            },
            enviar_datos_crear_evento(){
                object = this
                let formData = new FormData($("#formulario_crear")[0])
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
                        // console.log("success");
                        actualizar_datos();
                        misEventoSectionAppObject.cargar_datos()
                        eventoObject = createPopup(data)
                        eventoObject.datos.date = new Date(data.date)
                        eventoObject.popup.append()
                        object.eventos_agregados.push(eventoObject)
                    },
                    error: function(data){
                        console.log("error");
                    }
                });
                document.getElementById('latitud').value = null;
                document.getElementById('longitud').value = null;
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
                actualizar_listado_popus_visibles()
            },
            desactivar(){
                this.activo = false
                Object.values(this.eventos_cercanos).forEach((evento)=>evento.popup.remove())
            },
            // mostrar(event, index){
            //     if(event.target.tagName == "BUTTON"){
            //         return
            //     }
            //     showEventAppObject.showEventDetails(index)
            // },
            ubicar(index, event){
                if(event.target.tagName == "BUTTON"){
                    return
                }
                datos_evento = this.eventos_cercanos[index].datos
                quitar = this.ultimo_evento_mostrado == index
                if(this.ultimo_evento_mostrado_div){
                    this.ultimo_evento_mostrado_div.classList.remove("mostrando")
                }

                Object.values(this.eventos_cercanos).map((x)=>{
                    if(x.id != datos_evento.id && !quitar){
                        // x.popup.remove()
                        x.popup.containerDiv.style.opacity = 0.15
                    }else{
                        // x.popup.setMap(MapaGoogleObject.mapa)
                        x.popup.containerDiv.style.opacity = 1
                    }
                })
                MapaGoogleObject.mapa.setCenter(new google.maps.LatLng(Number(datos_evento.lat), Number(datos_evento.lng)))
                this.ultimo_evento_mostrado = index
                if(quitar){
                    this.ultimo_evento_mostrado = null
                    $(event.target).closest(".evento_listado_container")[0].classList.remove("mostrando")
                }else{
                    $(event.target).closest(".evento_listado_container")[0].classList.add("mostrando")
                }
                this.ultimo_evento_mostrado_div =  $(event.target).closest(".evento_listado_container")[0]
            },
            joinEvent(event){
                console.log("envio unido")
                formData = new FormData(event.target.parentElement)
                $.ajax({
                    type:'POST',
                    url: "/api/JoinEvent",
                    data:formData,
                    cache:false,
                    contentType: false,
                    processData: false,
                    success:function(data){
                        console.log("unido")
                        // console.log("success");
                        actualizar_datos();
                        misEventoSectionAppObject.cargar_datos()
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
                        misEventoSectionAppObject.cargar_datos();
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
                return false
            },
            point(index){
                this.eventos_cercanos[index].popup.containerDiv.children[0].children[0].classList.add("mostrando")
                this.eventos_cercanos[index].popup.containerDiv.children[0].children[0].classList.add("mostrando")
            },
            notPoint(index){
                this.eventos_cercanos[index].popup.containerDiv.children[0].children[0].classList.remove("mostrando")
                this.eventos_cercanos[index].popup.containerDiv.children[0].children[0].classList.remove("mostrando")
            },
            actualizar_datos(){
                actualizar_datos()
            }
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
            }
        }

    })
    buscarEventoSectionAppObject = EventoSectionApp.mount("#buscarEventoSection")






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
    setInterval(actualizar_datos,3000)

}





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
                geoposicionUsuario:geoposicionUsuario
            };
        },
        template:template,
        methods:{
            activar(){
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

            },
            cargar_datos(){
                cargar_mis_eventos_creados()
                cargar_mis_eventos_unidos()
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
                        actualizar_datos()
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
                        actualizar_datos()
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
                this.modo = modo
                let eventos_a_poner = modo=="Eventos unidos"? this.eventos_unidos : this.eventos_creados;
                let eventos_a_quitar = modo=="Eventos unidos"? this.eventos_creados : this.eventos_unidos;

                eventos_a_poner? Object.values(eventos_a_poner).forEach((evento)=>evento.popup.append()) : null
                eventos_a_quitar? Object.values(eventos_a_quitar).forEach((evento)=>evento.popup.remove()) : null
            }
        },computed:{
            eventos_seleccionados(){
                if (this.modo == "Eventos unidos"){
                    return this.eventos_unidos
                }else{
                    return this.eventos_creados
                }
            },
            TAGS(){
                return TAGS
            }
        }
    })

    misEventoSectionAppObject = MisEventoSectionApp.mount("#misEventoSection")


    // Mis eventos data;
    function cargar_mis_eventos_unidos(){
        $.get("./api/MyJoinedEvents",function(eventos){
            data = {}
            eventos.forEach((evento)=>{
                if(!(evento.id in misEventoSectionAppObject.eventos_unidos)){
                    eventoObject = createPopup(evento)
                }else{
                    eventoObject = misEventoSectionAppObject.eventos_unidos[evento.id]
                }
                eventoObject.datos.distancia = getDistanceFromLatLonInKm(geoposicionUsuario.lat,geoposicionUsuario.lng,evento.lat,evento.lng)
                eventoObject.datos.date = new Date(evento.date)
                if(misEventoSectionAppObject.modo=="Eventos unidos" && misEventoSectionAppObject.activo){
                    eventoObject.popup.append()
                }
                data[evento.id] = eventoObject
            })
            misEventoSectionAppObject.eventos_unidos = data
        })
    }
    cargar_mis_eventos_unidos()
    setInterval(()=>{if(misEventoSectionAppObject.activo){cargar_mis_eventos_unidos()}},3000)

    function cargar_mis_eventos_creados(){
        $.get("./api/MyCreatedEvents",function(eventos){
            data = {}
            eventos.forEach((evento)=>{
                if(!(evento.id in misEventoSectionAppObject.eventos_creados)){
                    eventoObject = createPopup(evento)
                }else{
                    eventoObject = misEventoSectionAppObject.eventos_creados[evento.id]
                }
                eventoObject.datos.distancia = getDistanceFromLatLonInKm(geoposicionUsuario.lat,geoposicionUsuario.lng,evento.lat,evento.lng)
                eventoObject.datos.date = new Date(evento.date)
                if(misEventoSectionAppObject.modo=="Eventos creados" && misEventoSectionAppObject.activo){
                    eventoObject.popup.append()
                }
                data[evento.id] = eventoObject
            })
            misEventoSectionAppObject.eventos_creados = data
        })
    }
    cargar_mis_eventos_creados()
    setInterval(()=>{if(misEventoSectionAppObject.activo){cargar_mis_eventos_creados()}},3000)
}












var showEventAppObject;
showEventApp = createApp({
    data(){
        return{
            modal:$("#modal")[0],
            index:null,
        }
    },
    methods:{
        showEventDetails(nuevoIndice){
            this.modal.style.display = "block"
            this.index = nuevoIndice
        }
    },
    computed:{
        evento(){
            if(this.index == null){return {}}
            // return MapaGoogleObject.marcadores[this.index].datos
        }
    },template:
    "<h1>{{evento['name']}}</h1>"
})
showEventAppObject = showEventApp.mount($("#modal-content")[0])



function desactivarGlobal(){
    crearEventoSectionAppObject.desactivar()
    buscarEventoSectionAppObject.desactivar()
    profileSectionAppObject.desactivar()
    misEventoSectionAppObject.desactivar()
}

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
