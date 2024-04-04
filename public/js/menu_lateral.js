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



// PROFILE_DATA;

//TAGS, las tags existentes
$.get("./api/AllTags",function(raw_data){
    data ={}
    raw_data.forEach(dato => {
        data[dato.id] = {categoria:dato.categoria,id:dato.id}
    });
    TAGS = data
})

//USER_IMAGES, las iamgenes que son del usuario
var resolver_cargado_iamgenes;
var promesa_imagenes = new Promise((res)=>resolver_cargado_iamgenes=res)
function cargar_imagenes(appObject=null){

    $.get("./api/MyPhotos",function(raw_data){
        data ={}
        raw_data.forEach(dato => {
            data[dato.id] = {ruta:dato.ruta, id:dato.id}
        });
        USER_IMAGES = data
        resolver_cargado_iamgenes()

        if(appObject){
            appObject.datos=USER_IMAGES
        }
    })
}
cargar_imagenes()

var cargado_perfil;
var promesa_perfil= new Promise((res)=>cargado_perfil=res)
function cargar_perfil(){
    $.get("./api/MyProfile",function(data){
        PROFILE_DATA = data[0]
        cargado_perfil()
        if(profileSectionAppObject){
            profileSectionAppObject.data = PROFILE_DATA
        }
    })
}
cargar_perfil()




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
            desactivar(){
                this.activo = false
            },
            imagen(id){
                return "images/uploads/"+USER_IMAGES[id].ruta
            },
            iniciar_escucha(){
                setTimeout(()=>
                    document.getElementById('choose_imagen_nueva').addEventListener('change', (e)=> {
                        if (e.target.files[0]) {
                            // preview =document.createElement("img")
                            // var reader  = new FileReader();
                            // reader.onloadend = function () {
                            //     preview.src = reader.result;
                            // }
                            // reader.readAsDataURL(e.target.files[0]);

                            // preview.src = e.target.files[0].name
                            // document.getElementById('listado_imagenes').appendChild(preview)

                            this.subir_imagen()
                        }})
                ,100)
            },
            subir_imagen(){
                let formData = new FormData($("#formulario_subir_foto")[0])

                $.ajax({
                    type:'POST',
                    url: "/api/uploadImage",
                    data:formData,
                    cache:false,
                    contentType: false,
                    processData: false,
                    success:function(data){
                        console.log("success");
                        console.log(data);
                        setTimeout(()=>cargar_imagenes(chooseImageSectionObject),250)
                    },
                    error: function(data){
                        console.log("error");
                        console.log(data);
                    }
                });

            },
            elegir_imagen(image){
                if(this.modo == "perfil"){

                    $.ajax({
                        url: "/api/MyProfile/ChangePhoto/"+image.id,
                        type: 'GET',
                        success: function(data) {
                            cargar_perfil()
                        }
                    });


                }else if(this.modo == "evento"){
                    document.querySelector("#imagen_id").value = image.id
                    this.preview = "images/uploads/"+image.ruta
                }

                this.desactivar()
            }
        },computed:{
            imagenes(){
                return this.datos
            }
        }
    })
    chooseImageSectionObject =chooseImageSection.mount("#"+montaje)
}





var profileSectionAppObject;
async function crearProfileSectionApp(template){
    await promesa_perfil;
    ProfileSectionApp = createApp({
        data(){
            crearChooseImageSectionApp("perfil","choose_images_profiles")
            $("#profile_button").on("click",function(){profileSectionAppObject.activar()})
            return {
                activo:true,
                data:PROFILE_DATA
            };
        },
        template:template,
        methods:{
            activar(){
                desactivarGlobal()
                this.activo = true
                crearChooseImageSectionApp("perfil","choose_images_profiles")
            },
            desactivar(){
                this.activo = false
            },
            crearChooseImageSectionApp(perfilOEvento,disparador,montaje){
                crearChooseImageSectionApp(perfilOEvento,disparador,montaje)
            },
            imagen(id){
                return "images/uploads/"+USER_IMAGES[id].ruta
            }
        },computed:{
            datos(){
                return this.data
            }
        }
    })
    profileSectionAppObject = ProfileSectionApp.mount("#perfilSection")
}



var crearEventoSectionAppObject;
function crearEventoSectionApp(template){

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
            };
        },
        template:template,
        methods:{
            activar(){
                desactivarGlobal()
                this.activo = true
                MapaGoogleObject.buttonObtenerUbicacion.style.opacity = "1"
                MapaGoogleObject.buttonObtenerUbicacion.style.pointerEvents = ""; //TODO revisar esto
                crearChooseImageSectionApp("evento","choose_image_event")

            },
            desactivar(){
                MapaGoogleObject.eliminarEventosObtenerUbicacion(true)
                MapaGoogleObject.buttonObtenerUbicacion.style.opacity = "0"
                MapaGoogleObject.buttonObtenerUbicacion.style.pointerEvents = "none";
                this.activo = false
            },
            crearChooseImageSectionApp(perfilOEvento,disparador,montaje){
                crearChooseImageSectionApp(perfilOEvento,disparador,montaje)
            },
            enviar_datos_crear_evento(){
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
                    url: "/api/CrearEvento",
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
        },computed:{
            tags(){
                return TAGS;
            }
        }
    })
    crearEventoSectionAppObject = EventoSectionApp.mount("#crearEventoSection")
}

var buscarEventoSectionAppObject;
function buscarEventoSectionApp(template){
    EventoSectionApp = createApp({
        data(){
            $("#buscar_eventos_button")[0].onclick =function(){buscarEventoSectionAppObject.activar()}
            return {
                activo:false,
                eventosVisibles:[],
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
            addEventoVisible(id){
                this.eventosVisibles.push(id)
                this.eventosVisibles.sort((a,b)=>{
                    let dist_a = this.eventos[a].evento.distancia
                    let dist_b = this.eventos[b].evento.distancia
                    if (dist_a<dist_b){return -1}
                    if (dist_a>dist_b){return 1}
                    else{return 0}
                })
            },
            vaciarEventosVisibles(){
                this.eventosVisibles=[]
            },
            quitarEventoVisible(id){
                this.eventosVisibles.splice(this.eventosVisibles.indexOf(id),1)
            },
            mostrar(index){
                showEventAppObject.showEventDetails(index)
            }
        },
        computed:{
            eventos(){
                return MapaGoogleObject.marcadores
            }
        }

    })

    buscarEventoSectionAppObject = EventoSectionApp.mount("#buscarEventoSection")
}


function desactivarGlobal(){
    crearEventoSectionAppObject.desactivar()
    buscarEventoSectionAppObject.desactivar()
    profileSectionAppObject.desactivar()
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
            return MapaGoogleObject.marcadores[this.index].datos
        }
    },template:
    "<h1>{{evento['nombre']}}</h1>"
})
showEventAppObject = showEventApp.mount($("#modal-content")[0])








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