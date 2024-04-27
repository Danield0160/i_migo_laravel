<form id="formulario_crear" :onsubmit="()=>{enviar_datos_crear_evento(); return false}">
@csrf
<div class="formulario m-3" v-if="activo">

    <div class="form-group mt-2">
        <label for="name">Nombre del evento</label>
        <input name="name" id="name" type="text" class="form-control @error('name') is-invalid @enderror" required>
    </div>

    <div class="form-group mt-2">
        <label for="description">Descripcion del evento</label>
        <input name="description" id="description" type="text" class="form-control @error('description') is-invalid @enderror" required>
    </div>

    <div class="form-group mt-2">
        <label for="limite">Número de asistentes</label>
        <input name="limite" id="limite" type="number" class="form-control @error('limite') is-invalid @enderror" min=0 required>
    </div>

    <div class="dual">

        <div class="form-group">
            <label for="latitud">latitud</label>
            <input name="latitud" id="latitud" type="text" class="form-control @error('latitud') is-invalid @enderror" required disabled>
        </div>

        <div class="form-group">
            <label for="longitud">longitud</label>
            <input name="longitud" id="longitud" type="text" class="form-control @error('longitud') is-invalid @enderror" required disabled>
        </div>

    </div>

    <div class="form-group mt-2">
        <label for="date">Fecha</label>
        <input :min='new Date().toISOString().split("T")[0]' name="date" id="date" type="date" class="form-control @error('date') is-invalid @enderror" required>
    </div>

    <div class="form-group mt-2">
        <label for="time">Hora</label>
        <input name="time" id="time" type="time" class="form-control @error('time') is-invalid @enderror" required>
    </div>

    {{-- <div class="form-group form-check mt-2">
        <input name="sponsored" id="sponsored" type="checkbox" class="form-check-input @error('sponsored') is-invalid @enderror" required>
        <label class="form-check-label" for="sponsored">Patrocinio</label>
    </div> --}}

    {{-- <div class="form-group mt-2">
        <label for="imagen">Imagen</label>
        <br>
        <input name="imagen" id="imagen" type="file" class="form-control-file @error('imagen') is-invalid @enderror">
    </div> --}}

    <div id="choose_image_event"></div>
    <input type="text" name="imagen" id="imagen_id" style="display: none">
    @{{crearChooseImageSectionApp("evento","choose_image_event")}}



    <details>
        <summary>Tags</summary>
        <fieldset name="tags" id="tags" style="overflow: scroll; height:155px" >
            <div v-for="tag in tags" @click="seleccionar($event)" class="tag_div">
                <label>@{{tag.category_name}}
                    <input type="checkbox" :value="tag.id" class="checkbox_create_event_tag" hidden/>
                </label>
            </div>
        </fieldset>
    </details>



    <button type="submit" class="btn btn-primary mt-2 boton_envio">Enviar</button>

</div>
</form>
