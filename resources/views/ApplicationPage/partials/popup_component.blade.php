<div class="popup-evento evento" >
    <div class="popup-icono icono"></div>
    <div class="popup-contenido contenido">
        <div class="popup-imagen imagen">
            <img :src='"images/"+datos.imagen_id' alt="Imagen del evento">
        </div>
        <div class="popup-datos datos">
            <h4><i>@{{datos.name}}</i></h4>
            <p><b>Fecha:</b> @{{new Date(datos.date).toLocaleDateString("es-ES",{weekday:"long", year:"numeric",month:"long",day:"numeric"})}}</p>
            <p><b>Hora:</b> @{{new Date(datos.date).getHours()}} : @{{String(new Date(datos.date).getMinutes()).padStart("2","0")}}</p>
            <p class="popup-asistencia"><b>Asistentes</b>: @{{datos.asistentes}} / @{{datos.assistants_limit}}</p>
        </div>
    </div>
</div>