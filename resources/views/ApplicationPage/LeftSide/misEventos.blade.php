<div v-if="activo">

    {{-- seleccionador del modo --}}
    <div>
        <button @click="this.modo='Eventos unidos'">Eventos unidos</button>
        <button @click="this.modo='Eventos creados'">Eventos creados</button>
    </div>

    {{-- modo eventos unidos --}}
    <div v-if="this.modo == 'Eventos unidos'">
        <span>tus Eventos unidos</span>

        {{-- iterador de eventos unidos --}}
        <div v-for="evento_unido in eventos_unidos" class="evento_listado_container">
            {{-- TODO: hacer que la tarjeta de evento sea un componente --}}

            {{-- imagen del evento --}}
            <img :src=' "images/" + evento_unido.imagen_id 'alt="" >

            {{-- informacion del evento --}}
            <div class="contenido">

                <h4>@{{evento_unido.nombre}}</h4>
                <p>@{{evento_unido.descripcion}}</p>
                <p>@{{evento_unido.asistentes}} / @{{evento_unido.limite_asistentes}}</p>
                <span class="kilometraje">@{{Math.trunc(distancia(evento_unido.lat,evento_unido.lng) * 100)/100}} km</span>

            </div>

            {{-- boton para salirse del evento --}}
            <form onsubmit="return false" method="POST">
                @csrf
                <input id="event_id" name="event_id" type="text" :value="evento_unido.id" hidden>
                <button @click="salirse_de_evento($event)" >salirse</button>
            </form>

        </div>
    </div>

    {{-- modo eventos creados --}}
    <div v-if="this.modo == 'Eventos creados'">
        <span>tus Eventos creados</span>

        {{-- iterador de eventos creados --}}
        <div v-for="evento_creado in eventos_creados" class="evento_listado_container">

            {{-- imagen del evento --}}
            <img :src=' "images/" + evento_creado.imagen_id 'alt="" >

            {{-- informacion del evento --}}
            <div class="contenido">

                <h4>@{{evento_creado.nombre}}</h4>
                <p>@{{evento_creado.descripcion}}</p>
                <p>@{{evento_creado.asistentes}} / @{{evento_creado.limite_asistentes}}</p>
                <span class="kilometraje">@{{Math.trunc(distancia(evento_creado.lat,evento_creado.lng) * 100)/100}} km</span>

            </div>

            {{-- boton para eliminar el evento --}}
            <form onsubmit="return false">
                @method("DELETE")
                @csrf
                <input id="event_id" name="event_id" type="text" :value="evento_creado.id" hidden>
                <button @click="eliminar_evento($event)" >eliminar</button>
            </form>

        </div>
    </div>

</div>