<button @click="this.activo=!this.activo"><i v-if="modo=='perfil'" class="fa-solid fa-repeat"></i><i v-else class="fa-solid fa-file-image"> elegir imagen</i></button>
<div v-if="activo">
    <div id="listado_imagenes">
        <form id="formulario_subir_foto" onsubmit="return false">
            @csrf
            <label id='choose_imagen_nueva'><i class="fa-solid fa-upload"></i><p>Subir imagen</p><input name='file_upload' id='file_upload' type='file'></label>
        </form>
        <div v-for='image in imagenes'>
            <img :src="'images/uploads/' + image.ruta" @click="elegir_imagen(image)">
        </div>
    </div>
    @{{iniciar_escucha()}}

</div>
<div v-if="preview" id="preview">
    <img :src="preview" alt="" >
</div>