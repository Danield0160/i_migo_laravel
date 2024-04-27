<button type="button" @click="this.activo=!this.activo"><i v-if="modo=='perfil'" class="fa-solid fa-repeat"></i><i v-else class="fa-solid fa-file-image"> elegir imagen</i></button>
<div v-if="activo">
    <div id="listado_imagenes">
        <form id="formulario_subir_foto" onsubmit="return false">
            @csrf
            <label id='choose_imagen_nueva'><i class="fa-solid fa-upload"></i><p>Subir imagen</p><input name='file_upload' id='file_upload' type='file'></label>
        </form>
        <div>
            <img :src="'images/1'" @click="elegir_imagen(1)">
        </div>
        <div v-for='image in imagenes'>
            <img :src="'images/'+ image.id" @click="elegir_imagen(image.id)">
            <form onsubmit="return false" class="form_delete_image">
                @csrf
                @method("DELETE")
                <input type="text" name="id" hidden :value='image.id'>
                <button type="button" @click="remove_image($event)">X</button>
            </form>
        </div>
    </div>
    @{{iniciar_escucha()}}

</div>
<div v-if="preview" id="preview">
    <img :src="preview" alt="" >
    <br>
    preview
</div>