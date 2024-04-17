<button @click="this.activo=!this.activo">elegir imagen</button>
<div v-if="activo">

    <div>Elige una imagen</div>
    <form id="formulario_subir_foto" onsubmit="return false">
        @csrf
        <label id='choose_imagen_nueva'>+<input name='file_upload' id='file_upload' type='file'></label>
    </form>
    <div id="listado_imagenes">
        <div v-for='image in imagenes'>
            <img :src="'images/uploads/' + image.ruta" @click="elegir_imagen(image)">
        </div>
    </div>
    @{{iniciar_escucha()}}

</div>
<div v-if="preview" id="preview">
    <img :src="preview" alt="" >
</div>