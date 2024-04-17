<div id="footer_profile"  v-if="cargado && activo">
    <div class="image">
        <img :src="imagen(datos.profile_photo_id)" alt="">
    </div>

    <div id="choose_images_profiles"></div>
    @{{crearChooseImageSectionApp("perfil","choose_images_profiles")}}

    <div class="info">
        <p class="name">
            @{{datos.name}}
        </p>
        <p class="id">
            @{{datos.id}}
        </p>
    </div>
    <div class="logout">
        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">logout</a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            {{ csrf_field() }}
        </form>
    </div>
</div>