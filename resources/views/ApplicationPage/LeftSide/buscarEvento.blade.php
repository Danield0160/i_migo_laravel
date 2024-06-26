<div v-if="activo">
    <div id="div_buscador_eventos">
        <input type="text" v-model="input" placeholder="{{__('messages.placeHolderBuscar')}}" id="buscador_eventos">
    </div>
    <div id="listado_eventos_visibles">
        <TransitionGroup name="list"   >
            {{-- iterador de eventos --}}
            <div v-for="evento in eventosVisibles" class="evento_listado_container" v-on:click="ubicar($event,evento,this.eventosCercanos.map((x)=>x.popup))" :key="evento.datos.id" @mouseover=evento.popup.point() @mouseleave=evento.popup.notPoint() v-bind:class="ultimo_evento_mostrado == evento.datos.id ? 'mostrando' : 'null' ">
                {{-- imagen del evento --}}
                <div class="img">
                    <img :src='"images/"+evento.datos.imagen_id'alt="">
                </div>

                <div class="contenido">
                    {{-- informacion principal del evento --}}
                    <div class="datos">
                        <h4>@{{evento.datos.name}}</h4>
                        <p class="date">@{{evento.datos.date.toLocaleDateString()}} - @{{evento.datos.date.toLocaleTimeString('es-ES',{hour: '2-digit', minute:'2-digit'})}}</p>
                        <p>@{{evento.datos.description}}</p>
                    </div>

                </div>

                <div class="boton_container">
                    <span class="kilometraje">@{{Math.trunc(evento.datos.distancia * 100)/100}} km</span>

                    <div>

                        {{-- Boton para unirse al evento --}}
                        <form onsubmit="return false" method="POST" v-if="me_puedo_unir(evento.datos.id)">
                            @csrf
                            <input id="event_id" name="event_id" type="text" :value="evento.datos.id" hidden>
                            <button class="button_unir" @click="joinEvent($event)">
                                {{ __('messages.join_event') }}
                                <p>@{{evento.datos.asistentes}} / @{{evento.datos.assistants_limit}}</p>
                            </button>
                        </form>

                        {{-- Boton para salirse del evento --}}
                        <form onsubmit="return false" method="POST" v-if="me_puedo_salir(evento.datos.id)">
                            @csrf
                            <input id="event_id" name="event_id" type="text" :value="evento.datos.id" hidden>
                            <button class="button_salir" @click="salirse_de_evento($event)" v-if="evento.datos.asistentes < evento.datos.assistants_limit">
                                {{ __('messages.leave_event') }}
                                <p>@{{evento.datos.asistentes}} / @{{evento.datos.assistants_limit}}</p>
                            </button>
                            <button class="button_salir" v-else>
                                {{ __('messages.full') }}
                                <p>@{{evento.datos.asistentes}} / @{{evento.datos.assistants_limit}}</p>
                            </button>
                        </form>
                        <span style="font-size: small" v-if="es_propietario(evento.datos.id)">{{ __('messages.owner') }}</span>

                    </div>
                    {{-- <div> --}}
                        {{-- <button @click="ubicar(evento.datos)">ubicar</button> --}}
                        {{-- //TODO:moverlo a mis eventos y que cree un popup, o que cada menu tenga sus propios marcadores --}}
                    {{-- </div> --}}

                </div>

                {{-- Tags del evento --}}
                <div class="tags_buscar_evento" v-if="evento.datos.tags">
                    <span v-for="tag in evento.datos.tags.split(',')">@{{tag}} </span>
                </div>


            </div>

        </TransitionGroup>

    </div>
    <div id="decorador_listado"></div>
</div>

