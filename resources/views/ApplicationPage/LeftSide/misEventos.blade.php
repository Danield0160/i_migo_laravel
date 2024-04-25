<div v-if="activo">

    {{-- seleccionador del modo --}}
    <div id="selector_mis_eventos" onclick="if(event.target.tagName == 'BUTTON'){[...this.children].forEach((x)=>x.classList.remove('activo')); event.target.classList.add('activo')}">
        <button @click="this.modo='Eventos unidos'" class="activo boton_selector">Eventos unidos</button>
        <button @click="this.modo='Eventos creados'" class="boton_selector">Eventos creados</button>
    </div>

    {{-- modo eventos unidos --}}
    <div id="listado_eventos_visibles">
        <TransitionGroup name="list"   >

            {{-- iterador de eventos --}}
            <div v-for="evento in eventos_seleccionados" class="evento_listado_container" :key="evento.id">

                {{-- imagen del evento --}}
                <div class="img">
                    <img :src=' "images/" + evento.imagen_id 'alt="" >
                </div>

                {{-- informacion del evento --}}
                <div class="contenido">
                    <div class="datos">
                        <h4>@{{evento.name}}</h4>
                        <p class="date">@{{new Date(evento.date).toLocaleDateString()}} - @{{new Date(evento.date).toLocaleTimeString('es-ES',{hour: '2-digit', minute:'2-digit'})}}</p>
                        <p>@{{evento.description}}</p>
                    </div>
                </div>

                <div class="boton_container">
                    <span class="kilometraje">@{{Math.trunc(evento.distancia * 100)/100}} km</span>

                    <div>
                        {{-- boton para salirse del evento --}}
                        <form onsubmit="return false" method="POST" v-if="this.modo == 'Eventos unidos'">
                            @csrf
                            <input id="event_id" name="event_id" type="text" :value="evento.id" hidden>
                            <button class="button_unir" @click="salirse_de_evento($event)" >
                                salirse
                                <p>@{{evento.asistentes}} / @{{evento.asistence_limit}}</p>
                            </button>
                        </form>

                        {{-- boton para aliminar el evento --}}
                        <form onsubmit="return false" v-if="this.modo == 'Eventos creados'">
                            @method("DELETE")
                            @csrf
                            <input id="event_id" name="event_id" type="text" :value="evento.id" hidden>
                            <button class="button_salir" @click="eliminar_evento($event)" >
                                eliminar
                                <p>@{{evento.asistentes}} / @{{evento.asistence_limit}}</p>
                            </button>
                        </form>
                    </div>

                </div>
                {{-- Tags del evento --}}
                <div class="tags_buscar_evento" v-if="evento.tags">
                    <span v-for="tag in evento.tags.split(',')">@{{TAGS[tag].category_name}} </span>
                </div>

            </div>

        </TransitionGroup>
    </div>



    {{-- modo eventos creados --}}
    {{-- <div v-if="this.modo == 'Eventos creados'"> --}}

        {{-- iterador de eventos creados --}}
        {{-- <div v-for="evento_creado in eventos_creados" class="evento_listado_container"> --}}

            {{-- imagen del evento --}}
            {{-- <img :src=' "images/" + evento_creado.imagen_id 'alt="" > --}}

            {{-- informacion del evento --}}
            {{-- <div class="contenido"> --}}

                {{-- <h4>@{{evento_creado.name}}</h4> --}}
                {{-- <p>@{{evento_creado.description}}</p> --}}
                {{-- <p>@{{evento_creado.asistentes}} / @{{evento_creado.asistence_limit}}</p> --}}
                {{-- <span class="kilometraje">@{{Math.trunc(distancia(evento_creado.lat,evento_creado.lng) * 100)/100}} km</span> --}}

            {{-- </div> --}}

            {{-- boton para eliminar el evento --}}
            {{-- <form onsubmit="return false"> --}}
                {{-- @method("DELETE") --}}
                {{-- @csrf --}}
                {{-- <input id="event_id" name="event_id" type="text" :value="evento_creado.id" hidden> --}}
                {{-- <button @click="eliminar_evento($event)" >eliminar</button> --}}
            {{-- </form> --}}

        {{-- </div> --}}
    {{-- </div> --}}

</div>