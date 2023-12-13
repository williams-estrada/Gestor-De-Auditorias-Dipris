<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href="{{asset('css/Login.css')}}">
        <script src="https://kit.fontawesome.com/f67351aa49.js" crossorigin="anonymous"></script>
        <title>Inicio de sesión</title>
    </head>
    <body>
    <div class="top-bar">
        <h2 class="top-title">Gestor de Auditorias DIPRIS</h2>
    </div>
        <div class="general-container" >
            <div class="form-container">
                <form class="" action="/" method="POST">
                    @csrf
                    <h2>Inicio de Sesión</h2>
                    <p></p>
                    <input type="email" name="correo_electronico" placeholder="Correo" />
                    <input type="password" name="contraseña" placeholder="Contraseña" />
                    <div class="button-container">@if (session('status'))
                        <div class="alert alert-warning" role="alert" style="opacity: 0.5">
                            {{ session('status') }}
                        </div>
                @endif
                        <button>Entrar</button>
                    </div>
                </form>
                <hr class="solid">
                <div class="contact">
                    <label>Dirección de Protección Contra Riesgos Sanitarios</label>
                    <label>Teléfono (961) 611 1185</label>
                    <label></label>
                </div>
                
                <div class="icon">
                        <img src="{{ asset('logo.jpg') }}" alt="">
                </div>
            </div>
        </div>
    </body>
</html>