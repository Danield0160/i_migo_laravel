    {{-- <link href="style.css" rel="stylesheet"> --}}

    <nav class="navbar navbar-expand-custom navbar-mainbg">
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                <div class="hori-selector"><div class="left"></div><div class="right"></div></div>
                <li class="nav-item active">
                    <a id="buscar_eventos_button" class="nav-link" href="javascript:void(0);"><i class="far fa-address-book"></i>{{ __('content.search_events') }}</a>
                </li>
                <li class="nav-item">
                    <a id="mis_eventos_button" class="nav-link" href="javascript:void(0);"><i class="far fa-clone"></i>{{ __('content.my_events.title') }}</a>
                </li>
                <li class="nav-item">
                    <a id="crear_evento_button" class="nav-link" href="javascript:void(0);"><i class="far fa-calendar-alt"></i>{{ __('content.create_event.title') }}</a>
                </li>
                <li class="nav-item">
                    <a id="profile_button" class="nav-link" href="javascript:void(0);"><i class="fas fa-tachometer-alt"></i>{{ __('content.profile') }}</a>
                </li>
            </ul>
        </div>
    </nav>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/{{'@'}}popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.min.js"></script>
    {{-- <script src="script.js"></script> --}}
