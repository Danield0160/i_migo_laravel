<div class="formulario m-3" v-if="activo">

    <div class="form-group mt-2">
        <label for="name">Nombre del evento</label>
        <input name="name" id="name" type="text" class="form-control @error('name') is-invalid @enderror">
    </div>

    <div class="form-group mt-2">
        <label for="descripcion">Descripcion del evento</label>
        <input name="descripcion" id="descripcion" type="text" class="form-control @error('descripcion') is-invalid @enderror">
    </div>

    <div class="form-group mt-2">
        <label for="limite">Número de asistentes</label>
        <input name="limite" id="limite" type="number" class="form-control @error('limite') is-invalid @enderror" min=0>
    </div>

    <div class="form-group" style="display: none">
        <label for="latitud">latitud</label>
        <input name="latitud" id="latitud" type="text" class="form-control @error('latitud') is-invalid @enderror">
    </div>

    <div class="form-group" style="display: none">
        <label for="longitud">longitud</label>
        <input name="longitud" id="longitud" type="text" class="form-control @error('longitud') is-invalid @enderror">
    </div>

    <div class="form-group mt-2">
        <label for="fecha">Fecha</label>
        <input name="fecha" id="fecha" type="date" class="form-control @error('fecha') is-invalid @enderror">
    </div>

    <div class="form-group mt-2">
        <label for="time">Hora</label>
        <input name="time" id="time" type="time" class="form-control @error('time') is-invalid @enderror">
    </div>

    <div class="form-group form-check mt-2">
        <input name="patrocinado" id="patrocinado" type="checkbox" class="form-check-input @error('patrocinado') is-invalid @enderror">
        <label class="form-check-label" for="patrocinado">Patrocinio</label>
    </div>

    <div class="form-group mt-2">
        <label for="imagen">Imagen</label>
        <br>
        <input name="imagen" id="imagen" type="file" class="form-control-file @error('imagen') is-invalid @enderror">
    </div>

    <button type="submit" class="btn btn-primary mt-2">Enviar</button>

</div>