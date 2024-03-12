<div v-if="activo">
    <input type="text">
    <div id="listado_eventos_visibles">
        <div v-for="index in eventos" class="evento_listado_container">
            <img :src='"images/uploads/"+datos[index].imagen'alt="">
            <div class="contenido">
                <h4>@{{datos[index].nombre}}</h4>
                <p>@{{datos[index].descripcion}}</p>
                <p>@{{datos[index].asistentes}} / @{{datos[index].limite_asistentes}}</p>
            </div>
        </div>
    </div>
</div>

