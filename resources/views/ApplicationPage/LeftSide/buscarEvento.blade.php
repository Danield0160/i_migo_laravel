<div v-if="activo">
    <div id="div_buscador_eventos">
        <input type="text" v-model="input" placeholder="Buscar eventos..." id="buscador_eventos">
    </div>
    <div id="listado_eventos_visibles">
        <TransitionGroup name="list"   >
            {{-- iterador de eventos --}}
            <div v-for="index in eventos_Visibles" class="evento_listado_container" v-on:click="ubicar(index,$event)" :key="index" @mouseover=point(index) @mouseleave=notPoint(index) v-bind:class="ultimo_evento_mostrado == index ? 'mostrando' : 'null' ">
                {{-- imagen del evento --}}
                <div class="img">
                    <img :src='"images/"+eventos[index].datos.imagen_id'alt="" v-if="eventos[index] !== undefined">
                </div>

                <div class="contenido" v-if="eventos[index] !== undefined">
                    {{-- informacion principal del evento --}}
                    <div class="datos">
                        <h4>@{{eventos[index].datos.name}}</h4>
                        <p class="date">@{{eventos[index].datos.date.toLocaleDateString()}} - @{{eventos[index].datos.date.toLocaleTimeString('es-ES',{hour: '2-digit', minute:'2-digit'})}}</p>
                        <p>@{{eventos[index].datos.description}}</p>
                    </div>

                </div>

                <div class="boton_container">
                    <span class="kilometraje">@{{Math.trunc(eventos[index].datos.distancia * 100)/100}} km</span>

                    <div>

                        {{-- Boton para unirse al evento --}}
                        <form onsubmit="return false" method="POST" v-if="me_puedo_unir(eventos[index].datos.id)">
                            @csrf
                            <input id="event_id" name="event_id" type="text" :value="eventos[index].datos.id" hidden>
                            <button class="button_unir" @click="joinEvent($event)">
                                unirse
                                <p>@{{eventos[index].datos.asistentes}} / @{{eventos[index].datos.asistence_limit}}</p>
                            </button>
                        </form>

                        {{-- Boton para salirse del evento --}}
                        <form onsubmit="return false" method="POST" v-if="me_puedo_salir(eventos[index].datos.id)">
                            @csrf
                            <input id="event_id" name="event_id" type="text" :value="eventos[index].datos.id" hidden>
                            <button class="button_salir" @click="salirse_de_evento($event)" v-if="eventos[index].datos.asistentes < eventos[index].datos.asistence_limit">
                                salirse
                                <p>@{{eventos[index].datos.asistentes}} / @{{eventos[index].datos.asistence_limit}}</p>
                            </button>
                            <button class="button_salir" v-else>
                                Esta lleno
                                <p>@{{eventos[index].datos.asistentes}} / @{{eventos[index].datos.asistence_limit}}</p>
                            </button>
                        </form>
                        <span style="font-size: small" v-if="es_propietario(eventos[index].datos.id)">propietario</span>

                    </div>
                    {{-- <div> --}}
                        {{-- <button @click="ubicar(eventos[index].datos)">ubicar</button> --}}
                        {{-- //TODO:moverlo a mis eventos y que cree un popup, o que cada menu tenga sus propios marcadores --}}
                    {{-- </div> --}}

                </div>

                {{-- Tags del evento --}}
                <div class="tags_buscar_evento" v-if="eventos[index].datos.tags">
                    <span v-for="tag in eventos[index].datos.tags.split(',')"> @{{TAGS[tag].category_name}} </span>
                </div>


            </div>

        </TransitionGroup>

    </div>
    <div id="decorador_listado"></div>
</div>

