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








var crearEventoSectionAppObject;
function crearEventoSectionApp(template){

    EventoSectionApp = createApp({
        data(){
            $("#crear_evento_button").on("click",function(){crearEventoSectionAppObject.activar()})
            return {activo:false};
        },
        template:template,
        methods:{
            activar(){
                desactivarGlobal()
                this.activo = true
            },
            desactivar(){
                console.log("des")
                this.activo = false
            }
        }
    })

    crearEventoSectionAppObject = EventoSectionApp.mount("#crearEventoSection")
}

var buscarEventoSectionAppObject;
function buscarEventoSectionApp(template){
    EventoSectionApp = createApp({
        data(){
            $("#buscar_eventos_button")[0].onclick =function(){console.log("busc click");buscarEventoSectionAppObject.activar()}
            return {
                activo:true,
                eventosVisibles:[]
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
                console.log(this.activo)
            },
            addEventoVisible(evento){
                this.eventosVisibles.push(evento)
            },
            vaciarEventosVisibles(){
                // this.eventosVisibles=[]
            }
        }

    })

    buscarEventoSectionAppObject = EventoSectionApp.mount("#buscarEventoSection")
}


function desactivarGlobal(){
    console.log(crearEventoSectionAppObject)
    crearEventoSectionAppObject.desactivar()
    buscarEventoSectionAppObject.desactivar()
}