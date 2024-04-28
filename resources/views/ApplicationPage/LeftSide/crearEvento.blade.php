<form id="formulario_crear" :onsubmit="()=>{enviar_datos_crear_evento(); return false}">
@csrf
<div class="formulario m-3" v-if="activo">

    <div class="form-group mt-2">
        <label for="name">{{ __('content.create_event.name') }}</label>
        <input name="name" id="name" type="text" class="form-control @error('name') is-invalid @enderror">
    </div>

    <div class="form-group mt-2">
        <label for="description">{{ __('content.create_event.description') }}</label>
        <input name="description" id="description" type="text" class="form-control @error('description') is-invalid @enderror">
    </div>

    <div class="form-group mt-2">
        <label for="limite">{{ __('content.create_event.max_people') }}</label>
        <input name="limite" id="limite" type="number" class="form-control @error('limite') is-invalid @enderror" min=0>
    </div>

    <div class="form-group dual">

        <div class="form-group">
            <label for="latitud">latitud</label>
            <input name="latitud" id="latitud" type="text" class="form-control disabled @error('latitud') is-invalid @enderror" required tabindex="-1">
        </div>

        <div class="form-group">
            <label for="longitud">longitud</label>
            <input name="longitud" id="longitud" type="text" class="form-control disabled @error('longitud') is-invalid @enderror" required tabindex="-1">
        </div>

    </div>

    <div class="form-group dual">

        <div class="form-group mt-2">
            <label for="date">{{ __('content.create_event.date') }}</label>
            <input :min='new Date().toISOString().split("T")[0]' name="date" id="date" type="date" class="form-control @error('date') is-invalid @enderror" required>
        </div>

        <div class="form-group mt-2">
            <label for="time">{{ __('content.create_event.time') }}</label>
            <input name="time" id="time" type="time" class="form-control @error('time') is-invalid @enderror" required>
        </div>

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

    <details>
        <summary>{{ __('content.create_event.tags') }}</summary>
        <fieldset name="tags" id="tags" style="overflow: scroll; height:155px" >
            <div v-for="tag in tags" @click="seleccionar($event)" class="tag_div">
                <label>@{{tag.category_name}}
                    <input type="checkbox" :value="tag.id" class="checkbox_create_event_tag" hidden/>
                </label>
            </div>
        </fieldset>
    </details>


    <div id="choose_image_event"></div>
    <input type="text" name="imagen" id="imagen_id" style="display: none">
    @{{crearChooseImageSectionApp("evento","choose_image_event")}}


    <button type="submit" class="btn btn-primary mt-2 boton_envio">Enviar</button>

</div>
</form>
