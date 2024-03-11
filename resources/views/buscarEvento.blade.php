<div v-if="activo">
    <input type="text">
    <div id="listado_eventos_visibles">
        <div v-for="index in eventos" >
            <div>
            @{{datos[index].nombre}}
            </div>
        </div>
    </div>
</div>