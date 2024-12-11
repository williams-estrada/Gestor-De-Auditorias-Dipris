<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>  -->
    <link rel="stylesheet" href="{{asset('css/Layout.css')}}">
    <script src="https://kit.fontawesome.com/f67351aa49.js" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
        
    <title>@yield('title')</title>
</head>
<body>
    <nav class="sidebar close">
        <header>
            <div class="image-text">
                <span class="image">
                    <div class="position-relative">
                        <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="{{route('mensaje.index')}}" data-toggle="dropdown">
                        <i class="fa-solid @if(auth()->user()->tipo_usuario == 'Cliente') fa-user @else fa-user-tie @endif"></i>

                        <span class="badge badge-pill badge-danger">
                            <i class="fa-regular fa-bell" style="font-size:0.9em"></i>
                            <span class="count">{{ auth()->user()->unreadNotifications->count() }}</span>
                        </span>
                        </a>
                    </div>
                
                </span>
                <div class="text logo-text">
                    <span class="name">{{ auth()->user()->usuario }}</span>
                    <span class="profession">{{ auth()->user()->tipo_usuario }}</span>
                </div>
            </div>
            <i class='fa-solid fa-caret-right toggle'></i>
        </header>
        
        <div class="container-fluid overflow-hidden">
            <div class="row vh-100 overflow-auto">
                
                    <div class="d-flex flex-sm-column flex-row flex-grow-1 align-items-center align-items-sm-start px-3 pt-2 text-white">
                        
                        <ul class="nav nav-pills flex-sm-column flex-row flex-nowrap flex-shrink-1 flex-sm-grow-0 flex-grow-1 mb-sm-auto mb-0 justify-content-center align-items-center align-items-sm-start" id="menu">
                            @if(auth()->user()->tipo_usuario == 'Cliente')
                            <li class="nav-item">
                                <a href="{{route('licitacion.create')}}" class="nav-link px-sm-0 px-2" title="Nueva Auditoria">
                                    <i class="fa-solid fa-file-circle-plus icon"></i><span class="text nav-text">Nueva Auditoria</span>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{route('licitacion.index')}}" class="nav-link px-sm-0 px-2" title="Mis Auditorias">
                                    <i class="fa-solid fa-folder icon"></i><span class="text nav-text">Mis Auditorias</span>
                                </a>
                            </li>

                            <li>
                                &nbsp;
                            </li>

                            <li>
                                &nbsp;
                            </li>

                            <li>
                                &nbsp;
                            </li>

                            <li>
                                &nbsp;
                            </li>

                            <li>
                                &nbsp;
                            </li>

                            <li>
                                &nbsp;
                            </li>

                            <li>
                                <a href="{{route('login.destroy')}}" class="nav-link px-sm-0 px-2">
                                    <i class="fa-solid fa-right-from-bracket icon"></i><span class="text nav-text">Cerrar Sesión</span></a>
                            </li>

                            @endif

                            @if(auth()->user()->tipo_usuario == 'Administrador')
                            <li class="nav-item">
                                <a href="{{route('usuarios.create')}}" class="nav-link px-sm-0 px-2">
                                    <i class="fa-solid fa-user-plus icon"></i><span class="text nav-text">Nuevo usuario</span>
                                </a>
                            </li>

                            <li>
                                <a href="{{route('usuarios.index')}}" title="Todos los usuarios">
                                    <i  class="fa-solid fa-users icon"></i>
                                    <span class="text nav-text">Todos los usuarios</span>
                                </a>
                                
                            </li>

                            <li>
                                <a href="{{route('configuracion.index')}}" class="nav-link px-sm-0 px-2">
                                    <i class="fa-solid fa-calendar-days icon"></i><span class="text nav-text">Registro de Feriados</span></a>
                            </li>

                            <li>
                                <a href="{{route('licitacion.create')}}" class="nav-link px-sm-0 px-2">
                                    <i class="fa-solid fa-file-circle-plus icon"></i><span class="text nav-text">Nueva Auditoria</span></a>
                            </li>

                            <li>
                                <a href="{{route('licitacion.index')}}" class="nav-link px-sm-0 px-2">
                                    <i class="fa-solid fa-folder icon"></i><span class="text nav-text">Mis Auditoria</span></a>
                            </li>

                            <li>
                                <a href="{{route('licitacion.all')}}" class="nav-link px-sm-0 px-2">
                                    <i class="fa-solid fa-box-archive icon"></i><span class="text nav-text">Todas las Auditorias</span></a>
                            </li>

                            <li>
                                <a href="{{route('licitacion.busqueda')}}" class="nav-link px-sm-0 px-2">
                                    <i class="fa-solid fa-file-zipper icon"></i><span class="text nav-text">Descargar documentos</span></a>
                            </li>

                            <li>
                                &nbsp;
                            </li>
                                
                            <li>
                                <a href="{{route('login.destroy')}}" class="nav-link px-sm-0 px-2">
                                    <i class="fa-solid fa-right-from-bracket icon"></i><span class="text nav-text">Cerrar Sesión</span></a>
                            </li>

                            @endif
                        </ul>
                        
                    </div>
                </div>
                            <!--</div>-->
        </div>
    </nav>
    <section class="home">
        <div class="text">@yield('title')</div>
        <div class="container">
			@yield('content')
		</div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script> 
    <script src="{{asset('JS/layout.js')}}"></script>
</body>
</html>

