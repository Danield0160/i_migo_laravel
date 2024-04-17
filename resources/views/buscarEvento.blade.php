<div v-if="activo">
    <input type="text" v-model="input" placeholder="Buscar eventos...">
    <div id="listado_eventos_visibles">

        <TransitionGroup name="list"   >
            {{-- iterador de eventos --}}
            <div v-for="index in eventos_Visibles" class="evento_listado_container" v-on:click="mostrar($event,index)" :key="index">

                {{-- imagen del evento --}}
                <img :src='"images/"+eventos[index].datos.imagen_id'alt="" v-if="eventos[index] !== undefined">

                {{-- informacion principal del evento --}}
                <div class="contenido" v-if="eventos[index] !== undefined">

                    <h4>@{{eventos[index].datos.nombre}}</h4>
                    <p>@{{eventos[index].datos.descripcion}}</p>
                    <p>@{{eventos[index].datos.asistentes}} / @{{eventos[index].datos.limite_asistentes}}</p>
                    <span class="kilometraje">@{{Math.trunc(eventos[index].datos.distancia * 100)/100}} km</span>

                    <div>
                        <div>

                            {{-- Boton para unirse al evento --}}
                            <form onsubmit="return false" method="POST" v-if="me_puedo_unir(eventos[index].datos.id)">
                                @csrf
                                <input id="event_id" name="event_id" type="text" :value="eventos[index].datos.id" hidden>
                                <button @click="unirse_a_evento($event)">unirse</button>
                            </form>

                            {{-- Boton para salirse del evento --}}
                            <form onsubmit="return false" method="POST" v-if="me_puedo_salir(eventos[index].datos.id)">
                                @csrf
                                <input id="event_id" name="event_id" type="text" :value="eventos[index].datos.id" hidden>
                                <button @click="salirse_de_evento($event)" >salirse</button>
                            </form>
                            <span v-if="es_propietario(eventos[index].datos.id)">propietario</span>

                        </div>
                        <div>
                            <button @click="ubicar(eventos[index].datos)">ubicar</button>
                            {{-- //TODO:moverlo a mis eventos y que cree un popup, o que cada menu tenga sus propios marcadores --}}
                        </div>

                    </div>

                </div>

                {{-- Tags del evento --}}
                <div class="tags_buscar_evento" v-if="eventos[index].datos.tags">
                    <span v-for="tag in eventos[index].datos.tags.split(',')">@{{TAGS[tag].categoria}}</span>
                </div>

            </div>

        </TransitionGroup>

    </div>
</div>

