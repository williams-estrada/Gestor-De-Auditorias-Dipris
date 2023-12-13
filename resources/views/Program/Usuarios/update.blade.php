
@extends('Layout')

@section('title')
    Actualización de Usuarios
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <form id="contact" method="post" action="{{ route('usuarios.update', $usuarios->id) }}" class="form">
                            @csrf
                            @method("PUT")
                            <h3 class="text-center mb-4">Actualización de Usuarios</h3>
                            <div class="mb-3">
                                <h4 class="text-center">Actualizar datos del usuario</h4>
                                <input value="{{ $usuarios->usuario }}" name="usuario" class="form-control" placeholder="Nombre del usuario" type="text" tabindex="1" required autofocus>
                                <input value="{{ $usuarios->correo_electronico }}" name="correo_electronico" class="form-control mt-3" placeholder="Email" type="email" tabindex="2" required>
                                <h4 class="text-center mt-3">Tipo de usuario:</h4>
                                <select name="tipo_usuario" class="form-select" required>
                                    <option value="Cliente" {{ $usuarios->tipo_usuario === 'Cliente' ? 'selected' : '' }}>Cliente</option>
                                    <option value="Administrador" {{ $usuarios->tipo_usuario === 'Administrador' ? 'selected' : '' }}>Administrador</option>
                                </select>
                                <input name="contraseña" class="form-control mt-3" placeholder="Contraseña" type="password" tabindex="3" required>
                            </div>
                            <div class="d-grid">
                                <button name="guardar" type="submit" class="btn btn-primary">Guardar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
