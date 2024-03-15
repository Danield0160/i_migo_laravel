<div v-if="activo">
    <input type="text">
    <div id="listado_eventos_visibles">

        <TransitionGroup name="list"   >
        <div v-for="index in eventosVisibles" class="evento_listado_container" v-on:click="mostrar(index)" :key="index">
                <img :src='"images/uploads/"+eventos[index].datos.imagen'alt="">
                <div class="contenido">
                    <h4>@{{eventos[index].datos.nombre}}</h4>
                    <p>@{{eventos[index].datos.descripcion}}</p>
                    <p>@{{eventos[index].datos.asistentes}} / @{{eventos[index].datos.limite_asistentes}}</p>
                    <span class="kilometraje">@{{Math.trunc(eventos[index].datos.distancia * 100)/100}} km</span>
                </div>
            </div>
        </TransitionGroup>

    </div>
</div>

