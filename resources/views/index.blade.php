@extends('layouts.app')

@section('content')

    <nav class="navbar navbar-expand-lg navbar-light fixed-top py-3" id="mainNav">
        <div class="container px-4 px-lg-5">
            <a class="navbar-brand nav-link" href="#page-top">Amig<i class="bi bi-geo-alt-fill"></i></a>
            <button class="navbar-toggler navbar-toggler-right" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ms-auto my-2 my-lg-0">
                    @auth
                    <li class="nav-item"><a class="nav-link" href="{{ route('app', app()->getLocale())}}">{{ __('messages.app') }}</a></li>
                    @endauth
                    <li class="nav-item"><a class="nav-link" href="#about">{{__("messages.about_us.title")}}</a></li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">{{ __('messages.language') }}</a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown" id="languageDropdown">
                            <li><a class="dropdown-item" href="{{ route('language.switch', 'es') }}">Español</a></li>
                            <li><a class="dropdown-item" href="{{ route('language.switch', 'en') }}">English</a></li>
                        </ul>
                    </li>



                    @guest
                    <li class="nav-item"><a class="nav-link"  data-bs-toggle="modal" data-bs-target="#loginModal">{{ __('messages.login') }}</a></li>
                    @endguest
                    @auth
                        @if (Auth::user()->admin == 1)
                            <li class="nav-item"><a class="nav-link" href="{{ route('management') }}">{{ __('messages.management.index') }}</a></li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <li class="nav-item">
                                    <button type="submit" class="btn btn-link nav-link">{{ __('messages.logout') }}</button>
                                </li>
                            </form>
                        @else
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <li class="nav-item">
                                <button type="submit" class="btn btn-link nav-link">{{ __('messages.logout') }}</button>
                            </li>
                        </form>
                        @endif
                    @endauth
                </ul>
            </div>
        </div>
    </nav>
    @include('includes.messages')

    <!-- Modal de inicio de sesión -->
    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-3" style="background: linear-gradient(rgba(0, 0, 0, 0.8), rgba(255, 69, 0, 0.8)); border: 2px solid #FF4500;">
                <div class="modal-header bg-dark text-white border-0 rounded-top">
                    <h5 class="modal-title" id="loginModalLabel">{{ __('messages.login') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Formulario de inicio de sesión -->
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label text-white">{{ __('messages.email') }}</label>
                            <input type="email" class="form-control" name="email" placeholder="{{ __('messages.example') }}" required autocomplete="email" autofocus>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label text-white">{{ __('messages.password') }}</label>
                            <input type="password" class="form-control" name="password" required>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-block">{{ __('messages.login') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

        <!-- Modal Registro-->
        <div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="crearCuentaModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content rounded-3" style="background: linear-gradient(rgba(0, 0, 0, 0.8), rgba(255, 69, 0, 0.8)); border: 2px solid #FF4500;">
                    <div class="modal-header bg-dark text-white border-0 rounded-top">
                        <h5 class="modal-title" id="crearCuentaModalLabel">{{ __('messages.register') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Formulario -->
                        <form method="POST" action="{{ route('users.store') }}">
                            @csrf
                            <div class="row justify-content-center">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-white">{{ __('messages.name') }}</label>
                                    <input type="text" class="form-control" value="{{ old('name') }}" name="name" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-white">{{ __('messages.surname') }}</label>
                                    <input type="text" class="form-control" value="{{ old('surname') }}" name="surname" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-white">{{ __('messages.dni') }}</label>
                                    <input type="text" class="form-control" name="dni" value="{{ old('dni') }}" required placeholder="12345678A">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-white">{{ __('messages.email') }}</label>
                                    <input type="text" class="form-control" name="email" value="{{ old('email') }}" required placeholder="{{ __('messages.example') }}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-white">{{ __('messages.password') }}</label>
                                    <input type="password" class="form-control" name="pass" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label text-white">{{ __('messages.password_confirmation') }}</label>
                                    <input type="password" class="form-control" name="pass_check" required>
                                </div>
                                <input type="hidden" name="role" value="user">
                            </div>
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-block">{{ __('messages.send') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    <!-- Masthead-->
    <header class="masthead">
        <div class="container px-4 px-lg-5 h-100">
            <div class="row gx-4 gx-lg-5 {{--h-100--}} align-items-center justify-content-center text-center" style="margin-top:100px">
                <div class="col-lg-8 align-self-end">
                    <h1 class="text-white font-weight-bold">{{ __('messages.welcome') }}</h1>
                    <hr class="divider"/>
                </div>
                <div class="col-lg-8 align-self-baseline">
                    <p class="text-white-75 mb-5">{{ __('messages.about_us.description_1') }}</p>
                    @guest
                        <a class="btn btn-primary btn-xl" href="#" data-bs-toggle="modal" data-bs-target="#registerModal">{{ __('messages.register') }}</a>
                    @endguest
                    @auth
                        <a class="btn btn-primary btn-xl" href="{{ route('app', app()->getLocale()) }}">{{ __('messages.explore') }}</a>
                    @endauth
                </div>
            </div>

            <div id="decoracion">
                <div id="mundo">
                    <div class="pinMapa"></div>
                    <div class="pinMapa pm1"></div>
                    <div class="pinMapa pm2"></div>
                    <div class="pinMapa pm3"></div>
                    <div class="pinMapa pm4"></div>
                    <div class="pinMapa pm5"></div>
                    <div class="pinMapa pm6"></div>
                    <img id="persona" src="https://media.tenor.com/GpxFWMY45p8AAAAi/walk-walking.gif" alt="">
                </div>
            </div>

        </div>
    </header>
    <!-- About-->
    <section class="page-section" id="about">
        <div class="container px-4 px-lg-5">
            <h2 class="text-center mt-0">{{ __('messages.about_us.title') }}</h2>
            <hr class="divider" />
            <div class="row gx-4 gx-lg-5">
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="mt-5">
                        <div class="mb-2"><i class="bi-laptop fs-1 text-primary"></i></div>

                        <p class="text-muted mb-0">{{ __('messages.about_us.description_1') }}</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="mt-5">
                        <div class="mb-2"><i class="bi bi-geo-alt fs-1 text-primary"></i></div>

                        <p class="text-muted mb-0">{{ __('messages.about_us.description_2') }}</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="mt-5">
                        <div class="mb-2"><i class="bi bi-people-fill fs-1 text-primary"></i></div>

                        <p class="text-muted mb-0">{{ __('messages.about_us.description_3') }}</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 text-center">
                    <div class="mt-5">
                        <div class="mb-2"><i class="bi-heart fs-1 text-primary"></i></div>

                        <p class="text-muted mb-0">{{ __('messages.about_us.description_4') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Footer-->
    <footer class="bg-light py-5">
        <div class="container px-4 px-lg-5"><div class="small text-center text-muted">Copyright &copy; 2024 - Daniel & Alberto - Amigo</div></div>
    </footer>
@endsection